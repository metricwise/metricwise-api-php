#!/bin/sh -e
RUN="docker compose -f docker-compose.test.yaml run --rm"
$RUN composer install
$RUN php vendor/bin/phpunit *Test.php
