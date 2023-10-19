#!/bin/sh
git pull
docker compose down
docker compose build
docker compose up -d
docker exec -t notar-app-1 ./docker-deploy.sh
