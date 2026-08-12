#!/usr/bin/env bash

echo "Waiting for PHP-FPM socket..."

while [ ! -S /var/run/php/php-fpm.sock ]; do
    sleep 0.1
done

echo "PHP-FPM socket is ready."

exec nginx