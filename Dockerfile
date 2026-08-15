FROM php:8.2-cli

# Instala apenas as extensões do banco de dados (TiDB)
RUN apt-get update && apt-get install -y libzip-dev zip unzip && docker-php-ext-install pdo_mysql zip

WORKDIR /app
COPY . .

# Engana o Laravel criando os arquivos que dizem que a instalação já foi concluída
RUN touch storage/installed
RUN touch .env

# Libera permissões de escrita
RUN chmod -R 777 storage bootstrap/cache

# Cria as tabelas e liga o servidor
CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public
