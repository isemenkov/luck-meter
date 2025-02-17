ARG CONTAINER_VERSION
ARG CONTAINER_TYPE

FROM php:$CONTAINER_VERSION-$CONTAINER_TYPE
WORKDIR /var/www

COPY ./docker/backend/config/*.ini /usr/local/etc/php/conf.d

RUN set -ex \
    && apk --no-cache add linux-headers autoconf g++ make oniguruma-dev libzip-dev libzip \
    # && postgresql-libs postgresql-dev
    && docker-php-ext-install mbstring opcache zip \
    # && docker-php-ext-install pgsql pdo_pgsql \
    && pecl install -f xdebug \
    && docker-php-ext-enable xdebug zip \
    && apk del oniguruma-dev autoconf g++ make \
    && rm -rf /var/cache/apk/* \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG USER_NAME
ARG USER_ID
ARG GROUP_NAME
ARG GROUP_ID

RUN if ! getent group ${GROUP_NAME}; then \
        addgroup -g ${GROUP_ID} ${GROUP_NAME}; \
    fi

RUN adduser -u ${USER_ID} -G ${GROUP_NAME} -s /bin/sh -D ${USER_NAME}

USER $USER_NAME

EXPOSE 9000
