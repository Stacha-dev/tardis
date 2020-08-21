# API Service Stacha.dev

## Instalace

1. Naklonovat repozitář: `git clone https://github.com/Stacha-dev/back-end.git`
3. Inicializovat submoduly: `git submodule init` a `git pull --recurse-submodule`
2. Nadefinovat připojení k DB `/config/common.ini` podle `/config/example_common.ini`
4. Spustit instalační script z bin `./install.sh`

## Vývoj

1. Před začátkem prací, aktualizovat vývojovou větev `develop` pomocí:
2. Přepnout na vývojovou větev: `git checkout develop`
3. Aktualizovat lokální repozitář `git pull --recurse-submodules`
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

Dokumentace implementovaných koncových bodů [POSTMAN](https://documenter.getpostman.com/view/10875200/T1LTdP9o?version=latest)