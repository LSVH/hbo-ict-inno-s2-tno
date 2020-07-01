FROM wordpress:cli

COPY ./docker/local /usr/local
COPY ./plugins /var/www/html/wp-content/plugins

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN apk update \
 && apk add git \
 && cd /usr/local/bin \
 && chmod +x \
    setup-wp wait-for-it

CMD setup-wp
