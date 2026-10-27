FROM ghcr.io/roadrunner-server/roadrunner:3.0.0 AS roadrunner

FROM php:8.5-cli-alpine

# https://github.com/mlocati/docker-php-extension-installer
# https://github.com/docker-library/docs/tree/0fbef0e8b8c403f581b794030f9180a68935af9d/php#how-to-install-more-php-extensions
RUN --mount=type=bind,from=mlocati/php-extension-installer:2,source=/usr/bin/install-php-extensions,target=/usr/local/bin/install-php-extensions \
     install-php-extensions @composer-2 opcache zip intl sockets

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

# Install build tools and headers required for compiling
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    linux-headers \
    zlib-dev

# Compile and enable the extension via PECL
RUN pecl install grpc \
    && docker-php-ext-enable grpc

# Clean up build dependencies to minimize image size
# RUN apk del --no-cache .build-deps

EXPOSE 8080 9001

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy application files
COPY . .

RUN composer install --optimize-autoloader --no-dev



# Run the RoadRunner server
CMD ["rr", "serve", "-c", ".rr.yaml"]