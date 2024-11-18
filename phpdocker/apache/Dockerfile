FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev libicu-dev zip unzip git curl \
    && docker-php-ext-install pdo_mysql pdo_pgsql intl

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Node.js y npm (opcional, si necesitas para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /application
