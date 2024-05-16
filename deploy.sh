#!/bin/sh
git pull
COMPOSE="docker compose"
CONTAINER="notar-app-1"
if command -v docker-compose; then
	COMPOSE="docker-compose"
	CONTAINER="notar_app_1"
fi

$COMPOSE down
$COMPOSE build
$COMPOSE up -d
docker exec -t --env-file .env $CONTAINER ./docker-deploy.sh
