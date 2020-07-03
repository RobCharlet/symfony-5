brew install postgres
docker-compose up -d
composer install
symfony server start -d
symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async
curl -s -I -X GET https://127.0.0.1:8000/
symfony server:log

Purge du HTTPCache
curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/
curl -I -X PURGE -u admin:admin `symfony var:export SYMFONY_DEFAULT_ROUTE_URL`/admin/http-cache/conference_header