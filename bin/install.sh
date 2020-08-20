#!/bin/sh
echo Install...

# Composer
cd ..
composer install

# ORM
read -p "Do you want to reload database? This will DELETE ALL the data in it. [y/n] " key -n 1 -r
if [ "$key" = 'y' ]; then
    composer orm:drop
    composer orm:create
fi

# NPM
cd ../public/admin
npm install
npm run build

echo Done!
