brew install postgres
docker-compose up -d
composer install
symfony server start -d
symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async
curl -s -I -X GET https://127.0.0.1:8000/
symfony server:log