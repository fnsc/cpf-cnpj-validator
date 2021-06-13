FROM leroymerlinbr/php:7.4
USER root

# Packages
RUN cd /tmp \
    && mkdir librdkafka \
    && cd librdkafka \
    && git clone https://github.com/edenhill/librdkafka.git . \
    && ./configure \
    && make \
    && make install \
    && rm -rf /tmp/*

# PHP Extensions
RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka \
    && rm -rf /tmp/*

# Xdebug
RUN docker-php-ext-enable xdebug
COPY custom.ini /usr/local/etc/php/conf.d/custom.ini

ARG UID=1000
ARG GID=1000

RUN groupmod -g ${GID} www-data \
  && usermod -u ${UID} -g www-data www-data \
  && chown -hR www-data:www-data \
    /var/www \
    /usr/local/

USER www-data:www-data