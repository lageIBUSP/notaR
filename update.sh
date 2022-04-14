#!/bin/sh
docker exec notar_app_1 composer update
docker exec notar_app_1 npm update
./deploy.sh
