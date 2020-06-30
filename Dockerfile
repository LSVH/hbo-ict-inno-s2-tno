FROM wordpress:cli

COPY docker/local /usr/local

USER root

RUN chmod +x /usr/local/bin/setup-wp /usr/local/bin/wait-for-it

COPY ./plugins ./wp-content/plugins

CMD setup-wp