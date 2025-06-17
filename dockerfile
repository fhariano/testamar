# Use imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd

# Instala Node.js (para compilar frontend)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configura diretório de trabalho
WORKDIR /var/www/html

# Copia arquivos da aplicação
COPY . .

# Instala dependências PHP e Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Ativa mod_rewrite do Apache
RUN a2enmod rewrite

# Permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expor porta padrão do Apache
EXPOSE 80

CMD ["apache2-foreground"]
