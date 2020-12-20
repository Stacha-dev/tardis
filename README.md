# API Service Stacha.dev

## Instalation

1. Clone repository: `git clone https://github.com/Stacha-dev/back-end.git && cd back-end`
2. Run install script `./bin/install.sh <db_user> <db_password> <db_name>`
3. Generate password for root user `composer app:password <password>`

## Development

1. Update `git pull develop` to get recent commits
2. Install composer dependencies `composer install`
3. Reload DB schema `composer orm:drop` and then `composer orm:create`
4. Create new branch by `git checkout -b <branch_name>`
    - Feature `feat/<feature_name>`
    - Bugfix `fix/<bugfix_name>`
5. Commit changes to repository
6. In case of feature add PHP Unit test suite
6. Create pull request into `develop` branch

## API

Endpoints: [POSTMAN](https://documenter.getpostman.com/view/10875200/T1LTdP9o?version=latest)

## Usefull commands

### App
-   Generate password `composer app:password <password>`

### ORM

-   Create DB schema `composer orm:create`
-   Update DB schema`composer orm:update`
-   Drop  DB schema`composer orm:drop`

### Composer

-   Install `composer require <package>`
-   Update `composer update`
-   Remove `composer remove <package>`

### PHPStan

-   Static analysis `composer phpstan`

### CS

-   Check cs `composer cs:fix`
-   Fix cs `composer cs`

### PHP Unit
-   Run all tests `composer test`
-   Generate test coverage `composer test:codecov`
