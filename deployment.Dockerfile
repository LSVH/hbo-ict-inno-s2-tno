FROM wordpress:cli

COPY docker/local /usr/local
COPY plugins /usr/local/etc/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

USER root

RUN apk update \
 && apk add git \
 && cd /usr/local/bin \
 && chmod +x \
    setup-wp wait-for-it

CMD setup-wp
