FROM php:7.3-cli

RUN pecl install swoole \
&& docker-php-ext-enable swoole; exit 0

RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
