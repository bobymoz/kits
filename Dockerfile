# Dockerfile para Deploy no Render com Supabase (PostgreSQL)
FROM php:8.3-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    nodejs \
    npm \
    postgresql-client

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do core Laravel
COPY Files/core/ .

# Criar diretório public
RUN mkdir -p public

# Copiar o index.php para a raiz pública
COPY Files/index.php public/index.php

# Copiar .htaccess se necessário
COPY Files/.htaccess public/.htaccess

# Instalar dependências PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Gerar APP_KEY se não existir (será sobrescrito pelas variáveis de ambiente)
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Criar diretórios necessários
RUN mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Definir permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Expor porta 8080 (padrão do Render)
EXPOSE 8080

# Script de inicialização
CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080"
