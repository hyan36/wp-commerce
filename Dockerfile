FROM wordpress

RUN docker-php-ext-install pdo pdo_mysql

COPY wordpress /var/www/html