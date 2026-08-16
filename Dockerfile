FROM php:8.2-apache

# Instala extensoes e ativa reescrita de URL do Apache
RUN apt-get update && apt-get install -y libzip-dev zip unzip git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd \
    && a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Aponta o Apache para a pasta 'public' do Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Remove instalador velho e instala Cloudinary
RUN rm -f composer.lock
RUN composer remove dacoto/laravel-wizard-installer --no-update --ignore-platform-reqs
RUN composer require cloudinary-labs/cloudinary-laravel --ignore-platform-reqs

# Engana a tela de instalacao
RUN touch storage/installed
RUN touch .env

# Da permissao total para o Apache ler e gravar arquivos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 storage bootstrap/cache

# No momento da inicializacao: Configura a porta do Render, limpa o cache e liga o Apache!
CMD sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && php artisan optimize:clear && php artisan migrate --force && apache2-foreground
