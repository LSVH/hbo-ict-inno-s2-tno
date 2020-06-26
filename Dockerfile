FROM wordpress:cli

COPY ./docker/bin /usr/local/bin
COPY ./docker/etc /usr/local/etc

USER root

RUN chmod +x /usr/local/bin/setup-wp /usr/local/bin/wait-for-it

COPY ./plugins ./wp-content/plugins

CMD setup-wp