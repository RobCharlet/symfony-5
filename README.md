https://guides.github.com/features/mastering-markdown/

`brew install postgres`

`docker-compose up -d`

`composer install`

`symfony server start -d`
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
symfony open:local:rabbitmq
symfony open:local:rabbitmq

## Et plus généralement :
symfony open:local:nomducontainerdocker