FROM php:8.2-cli

# Instala o suporte a banco de dados e a biblioteca GD (para não dar erro ao redimensionar imagens)
RUN apt-get update && apt-get install -y libzip-dev zip unzip git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Apaga o lock velho e remove o instalador fantasma com segurança
RUN rm -f composer.lock
RUN composer remove dacoto/laravel-wizard-installer --no-update --ignore-platform-reqs

# Instala o pacote oficial do Cloudinary no Laravel
RUN composer require cloudinary-labs/cloudinary-laravel --ignore-platform-reqs

# Engana a tela de instalação
RUN touch storage/installed
RUN touch .env

RUN chmod -R 777 storage bootstrap/cache

# Limpa o cache, atualiza o banco e roda o servidor
CMD php artisan optimize:clear && php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
