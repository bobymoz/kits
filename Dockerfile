FROM php:8.2-cli

# Instala dependências do sistema e a extensão pdo_mysql (para o TiDB)
RUN apt-get update && apt-get install -y libzip-dev zip unzip git && docker-php-ext-install pdo_mysql zip

# Copia o instalador do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Instala os pacotes do Laravel
RUN composer install --no-dev --optimize-autoloader

# Libera permissões de escrita
RUN chmod -R 777 storage bootstrap/cache

# Cria as tabelas no TiDB e liga o servidor
CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
