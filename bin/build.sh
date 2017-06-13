#!/bin/bash

cd "$(dirname ${BASH_SOURCE[0]})"
cd ..

rm -rf var/cache/*
rm -rf web/bundles
rm -rf web/css
rm -rf web/js
composer install
php bin/console cache:warmup
php bin/console assetic:dump