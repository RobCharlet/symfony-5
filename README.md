https://guides.github.com/features/mastering-markdown/

`brew install postgres`

`docker-compose up -d`

`composer install`

`symfony server:start -d`
symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async
curl -s -I -X GET https://127.0.0.1:8000/
symfony server:log

## Build Webpack assets`
symfony run -d yarn encore dev --watch

## Purge du HTTPCache
`curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/`
`curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/conference_header

## Ouvrir mailcatcher
symfony open:local:webmail

## Ouvrir RabbitMQ (guest/guest)
symfony open:local:rabbitmq

## Et plus généralement :
symfony open:local:nomducontainerdocker

## Démarrer le server du SPA (A la racine du dossier de celui-ci)
symfony server:start -d --passthru=index.html
--passthru=index.html indique que toutes les requetes HTTP doivent passer par public/html 

## Compiler le SPA
yarn encore dev

## Ouvrir le SPA en local
symfony open:local

## Définition du endpoint à la compilation
API_ENDPOINT=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL --dir=..` yarn encore dev

## Api en fond
API_ENDPOINT=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL --dir=..` symfony run -d --watch=webpack.config.js yarn encore dev --watch
