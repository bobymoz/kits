FROM php:8.2-cli

RUN apt-get update && apt-get install -y libzip-dev zip unzip && docker-php-ext-install pdo_mysql zip

WORKDIR /app
COPY . .

RUN touch storage/installed
RUN touch .env

RUN chmod -R 777 storage bootstrap/cache

# Limpa o cache velho, cria o atalho das imagens, atualiza o banco e roda o servidor
CMD php artisan optimize:clear && php artisan storage:link && php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
