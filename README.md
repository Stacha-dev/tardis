# API Service Stacha.dev

## Instalation

1. Clone repository: `git clone https://github.com/Stacha-dev/back-end.git && cd back-end`
2. Run install script `./bin/install.sh <db_user> <db_password> <db_name>`

## Development

1. Update `git pull develop` to get recent commits
2. Create new branch by `git checkout -b <branch_name>`
    - Feature `dev_<feature_name>`
    - Bugfix `fix_<bugfix_name>`
3. Commit changes to repository
4. Create pull request into `develop` branch

## API

Endpoints: [POSTMAN](https://documenter.getpostman.com/view/10875200/T1LTdP9o?version=latest)

## Usefull commands

### ORM

-   Create `composer orm:create`
-   Update `composer orm:update`
-   Drop  `composer orm:drop`

### Composer

-   Install `composer require <package>`
-   Update `composer update`

### PHPStan

-   Static analysis `composer phpstan`

### CS-Fixer

-   Fix cs `composer cs`

### PHP Unit
-   Run all tests `composer test`
-   Generate test coverage `composer test:codecov`
