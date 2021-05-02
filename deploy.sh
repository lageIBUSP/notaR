#!/bin/sh
git pull
docker-compose down
docker-compose build
docker-compose up -d
docker exec -t notar_app_1 ./docker-deploy.sh
