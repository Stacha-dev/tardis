# API Service Stacha.dev

## Použití DOCTRINE 0RM

Doctrine ORM je abstraktní databázová vrstva, která umožňuje pracovat s daty jako s objekty. [Seznam anotací](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/annotations-reference.html)

### Dustupné příkazy

-   Vygeneruje DB schéma na základě tříd.
    `vendor/bin/doctrine orm:schema-tool:create`
-   Aktualizuje DB schéma
    `vendor/bin/doctrine orm:schema-tool:update`
-   Dropne entity databáze
    `vendor/bin/doctrine orm:schema-tool:drop`

### Dostupné flagy

-   `--force`
-   `--dump-sql`

## Composer

-   Instalace balíčků
    `composer require <balíček>`

-   Obnovení autoloadu
    `composer dump-autoload -o`

## PHPStan

-   Kotrola src
    `vendor/bin/phpstan analyse src -l 8`

## Poznámky

-   URL ve tvaru base/version/controller/action.format?params
-   https://api.stacha.dev/1/article/all.json?order=newest

## Endpointy

Výpis implmentovancýh koncových bodů API.

### Články

-   Vyýpis jednoho článku podle ID `https://api.stacha.dev/1/article/one.json?id=1`
-   Vytvoření jedoho článku s `https://api.stacha.dev/1/article/one.json?title=test&content=Tohle je obsah článku`
