# API Service Stacha.dev

## Instalation

1. Clone repository: `git clone https://github.com/Stacha-dev/tardis.git && cd tardis`
2. Run install script `./bin/install.sh <db_user> <db_password> <db_name>`
3. Generate password for root user `composer app:password <password>`

## Development

1. Update `git pull develop` to get recent commits
2. Install composer dependencies `composer install`
3. Load DB schema `composer migrations:migrate` and generate proxies `composer orm:proxies`
4. Create new branch by `git checkout -b <branch-name>` follow this convention:
    - Feature `feat/<feature-name>`
    - Bugfix `fix/<bugfix-name>`
    - Chore `chore/<chore-name>`
5. Commit changes to the remote branch
6. In case of feature add PHP Unit test suite
6. Create pull request into `develop` branch follow this convention
    - `<type>(Scope): Description` example: `feat(User): Added user model`

## API

Endpoints: [POSTMAN](https://documenter.getpostman.com/view/10875200/T1LTdP9o?version=latest)

## Usefull Commands

### App

```
composer app:password <password>    // Generates password
```

### ORM

```
composer orm:create                 // Creates DB schema
composer orm:update                 // Updates DB schema
compsoer orm:drop                   // Drops DB schema
```

### Migrations

```
composer migrations:diff            // Generates differences in DB schema
composer migrations:status          // Show migration status
composer migrations:migrate         // Migrate to latest migration
composert migrations:migrate:prev   // Migrate to previous migration
```

### PHPStan

```
composer phpstan                    // Runs static analysis
```

### Coding Standards

```
composer cs                         // Checks coding standarts
composer cs:fix                     // Fixes coding standarts
```

### PHP Unit

```
composer test                       // Runs all unit tests
compsoer test:coverage              // Generates test coverage
```
