#!/usr/bin/env bash

if [ "$#" -ne 4 ]; then
	exit 1;
fi

USER=$1
PASSWORD=$2
DBNAME=$3
PORT=$4

# Composer
cd ..
composer validate
composer install

# DB
cd config
function generate_config() {
  eval "echo \"$(cat $1)\""
}

generate_config common.ini.tmpl > common.ini

cd ..
composer orm:drop
composer orm:create

# NPM
cd resources/admin
npm ci
npm run build:prod

exit 0;
