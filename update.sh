#!/bin/sh
docker exec notar_app_1 composer update
docker exec notar_app_1 npm update
./deploy.sh
echo "Lembre de testar as funcionalidades principais antes de subir essas mudanças para o repositório!!"
