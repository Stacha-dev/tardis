#!/usr/bin/env bash

# DB
USER=$1
PASSWORD=$2
DBNAME=$3
HOST="${4:-127.0.0.1}"
PORT="${5:-3306}"

echo $USER
echo $PASSWORD
echo $DBNAME
echo $HOST
echo $PORT

# Authorization
JWT_KEY=$(openssl rand -base64 32)

function generate_config() {
  eval "echo \"$(cat $1)\""
}

# Composer
cd ..
composer install

# Config
cd config
generate_config common.ini.tmpl > common.ini

cd ..
composer orm:drop
composer orm:create
