https://guides.github.com/features/mastering-markdown/

`brew install postgres`

`docker-compose up -d`

`composer install`

`symfony server:start -d`
`symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async`
`curl -s -I -X GET https://127.0.0.1:8000/`
`symfony server:log`

## Mise en place de la BDD
Modifié l'env pour ajouté le port relatif docker de postgre (docker ps)
Pour lire la base sur PHPStorm utiliser le vrai port
`symfony console doctrine:migrations:migrate`

## Créer un user admin
`symfony console security:encode-password`
`symfony run psql -c "INSERT INTO admin (id, username, roles, password) \
  VALUES (nextval('admin_id_seq'), 'admin2', '[\"ROLE_ADMIN\"]', \
'EncodedPassword');"`
Attention il faut échapper tous les $ ex \$argon2id\$v=19\$m=65536...

## Charger les fixtures
`symfony console doctrine:fixtures:load`

## Accéder à la console de la BDD
`symfony run psql si PSQL installé`
`docker exec -it guestbook_database_1 psql -U main -W main`

## Dump de la BDD
`symfony run pg_dump --data-only > dump.sql`
`symfony run psql < dump.sql`

## Build Webpack assets`
`symfony run -d yarn encore dev --watch`

## Purge du HTTPCache
`curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/`
`curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/conference_header

## Conf port mailcatcher
`symfony var:export`
Copier dans .env le port de MAILCATCHER_URL

## Ouvrir mailcatcher
`symfony open:local:webmail`

## Ouvrir RabbitMQ (guest/guest)
`symfony open:local:rabbitmq`


## Démarrer le server du SPA (A la racine du dossier de celui-ci)
`symfony server:start -d --passthru=index.html
--passthru=index.html indique que toutes les requetes HTTP doivent passer par public/html`

## Compiler le SPA
`yarn encore dev`

## Ouvrir le SPA en local
`symfony open:local`

## Définition du endpoint à la compilation
API_ENDPOINT=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL --dir=..` yarn encore dev

## Api en fond
API_ENDPOINT=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL --dir=..` symfony run -d --watch=webpack.config.js yarn encore dev --watch

## Mise à jour de la traduction (--domain=messages pour ne traduire que les messages non core type validation ou erreurs)
`symfony console translation:update fr --force --domain=messages`