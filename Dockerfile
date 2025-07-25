FROM rpungello/laravel-franken:8.4

ARG VERSION=1.0.0
ENV APP_VERSION=${VERSION}

ARG USER=pdf
ENV SERVER_NAME=:8000
ENV APP_NAME="Program IDs"

ARG FLUX_USERNAME

COPY . /app

RUN --mount=type=secret,id=FLUX_LICENSE_KEY \
    FLUX_USERNAME=${FLUX_USERNAME} \
    apt-get update && apt-get install -y ghostscript procps && apt-get clean \
 && composer config "http-basic.composer.fluxui.dev" "${FLUX_USERNAME}" "$(cat /run/secrets/FLUX_LICENSE_KEY)" \
 && composer install && npm install && npm run build \
 && chown -R www-data:www-data /app \
 && rm -f /app/auth.json

USER ${USER}

HEALTHCHECK --interval=5s --timeout=3s --retries=3 CMD php artisan status
