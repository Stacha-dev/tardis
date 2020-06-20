# API Service Stacha.dev

## Instalace

1. Naklonovat repozitář: `git clone https://github.com/Stacha-dev/back-end.git`
2. Nainstalovat závislosti: `composer install`
3. Nadefinovat připojení k DB `/config/common.ini`
4. Vytvoření schéma DB `vendor/bin/doctrine orm:schema-tool:create`

## Vývoj

1. Před začátkem prací, aktualizovat vývojovou větev `develop` pomocí:
2. Přepnout na vývojovou větev: `git checkout develop`
3. Aktualizovat lokální repozitář `git pull`
4. Vytvořit větev pro vývoj funčknosti `git checkout -b develop_nova_funkcnost` podle konvence pojmenování větví:
    - Pro novou či experimentální funčknost `develop_`
    - Pro opravu `bugfix_`
5. Zaverzovat změny pomocí `git add cesta/k/souboru` a `git commit -m "Popis změny"`
6. Odeslat změny do vzdáleného repozitáře pomocí `git push origin nazev_vetve`
7. Vytvoření pull requestu v GitHubu a po schválění změn sloučení s větví develop

## DOCTRINE 0RM

Doctrine ORM je abstraktní databázová vrstva, která umožňuje pracovat s daty jako s objekty. [Seznam anotací](https://www.doctrine-project.org/projects/doctrine-orm/en/2.7/reference/annotations-reference.html)

### Dustupné příkazy

-   Vygenerování DB schéma na základě entit `vendor/bin/doctrine orm:schema-tool:create`
-   Aktualizace DB `vendor/bin/doctrine orm:schema-tool:update`
-   Dropuje všechny entity databáze `vendor/bin/doctrine orm:schema-tool:drop`

#### Dostupné flagy

-   Vynucení `--force`
-   Příkaz se neprovede, vypíše se pouze náhled `--dump-sql`

## Composer

Slouží k udržování závislostí projektu a autoloadingu tříd.

### Dostupné příkazy

-   Instalace závislostí `composer require <balíček>`
-   Aktualizace závislostí `composer update`
-   Obnovení autoloadu `composer dump-autoload -o`

## PHPStan

Slouží k statické analýze kódu.

-   Spuštění pomocí příkazu `vendor/bin/phpstan analyse src -l max`

## API

Výpis implmentovancýh koncových bodů API.

### Články

-   Vyýpis všech článků `https://api.stacha.dev/1/article/get-all`
-   Vyýpis jednoho článku podle ID `https://api.stacha.dev/1/article/get-one?id=1`

## Poznámky

-   URL ve tvaru base/version/controller/action.format?params
-   https://api.stacha.dev/1/article/get-all?order=newest
