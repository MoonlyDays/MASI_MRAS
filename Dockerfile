FROM composer:latest AS composer
COPY . /app
WORKDIR /app
RUN composer install --no-dev --optimize-autoloader

FROM node:latest AS node
COPY . /app 
WORKDIR /app
RUN npm ci
RUN npm run build

FROM php:8.2-fpm-alpine
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer /app /app
COPY --from=node /app/public /app/public
WORKDIR /app
EXPOSE 8000
ENTRYPOINT ["sh", "entry.sh"]
