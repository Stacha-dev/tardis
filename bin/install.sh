#!/usr/bin/env bash

# DB
USER=$1
PASSWORD=$2
DBNAME=$3
HOST="${4:-127.0.0.1}"
PORT="${5:-3306}"

# Authorization
JWT_KEY=$(openssl rand -base64 32)

# Security
PEPPER=$(openssl rand -base64 32)

function generate_config() {
  eval "echo \"$(cat $1)\""
}

# Composer
composer install

# Config
generate_config config/common.ini.tmpl > config/common.ini

# ORM
composer orm:drop
composer orm:create
composer orm:genproxies
