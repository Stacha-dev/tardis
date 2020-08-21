#!/bin/sh
echo Install...

# Composer
cd ..
composer install

# ORM
composer orm:drop
composer orm:create

# NPM
cd resources/admin
npm install
npm run build:production

echo Done!
