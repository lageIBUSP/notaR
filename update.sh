#!/bin/sh
docker exec notar-app-1 composer update
docker exec notar-app-1 npm update
./deploy.sh
echo "Lembre de testar as funcionalidades principais antes de subir essas mudanças para o repositório!!"
