FROM php:8.0-apache

RUN docker-php-ext-install mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY ./docker/php.ini /usr/local/etc/php/

#RUN echo "[xdebug]" > /usr/local/etc/php/php.ini && \
#    echo "xdebug.mode=debug" >> /usr/local/etc/php/php.ini && \
#    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/php.ini && \
#    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini && \
#    echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/php.ini

#RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
#    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
#    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
#    echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
