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
    useradd ${USER} \
 && setcap -r /usr/local/bin/frankenphp \
 && composer config "http-basic.composer.fluxui.dev" "${FLUX_USERNAME}" "$(cat /run/secrets/FLUX_LICENSE_KEY)" \
 && composer install && npm install && npm run build \
 && mkdir /config/psysh && chown -R ${USER}:${USER} /config/psysh \
 && chown -R ${USER}:${USER} /data/caddy && chown -R ${USER}:${USER} /config/caddy \
 && chown -R ${USER}:${USER} /app \
 && rm -f /app/auth.json

USER ${USER}

HEALTHCHECK --interval=5s --timeout=3s --retries=3 CMD php artisan status
