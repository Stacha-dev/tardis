#!/usr/bin/env bash

if [ "$#" -ne 3 ]; then
	exit 1;
fi

# DB
USER=$1
PASSWORD=$2
DBNAME=$3

# Authorization
JWT_KEY=$(openssl rand -base64 32)

function generate_config() {
  eval "echo \"$(cat $1)\""
}

# Composer
cd ..
composer validate
composer install

# Config
cd config
generate_config common.ini.tmpl > common.ini

cd ..
composer orm:drop
composer orm:create
