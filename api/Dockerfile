FROM php:8-fpm-alpine3.14

# installation bash
RUN apk --no-cache update && apk --no-cache add bash git

# copy des scripts
COPY ./scripts /scripts

# installation de composer CORRECTEMENT
RUN chmod +x /scripts/ -R \
&& /scripts/composer-install.sh \
&& mv composer.phar /usr/local/bin/composer

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

# PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# installation de symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash \
&& mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY /dev/ /app/
WORKDIR /app

RUN symfony composer install

EXPOSE 8000
CMD symfony server:start --no-tls
