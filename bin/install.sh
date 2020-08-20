#!/bin/sh
echo Install...

# Composer
cd ..
composer install

# ORM
composer orm:drop
composer orm:create

# NPM
cd public/admin
npm install
npm run build

echo Done!
