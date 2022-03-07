# notaR
[![deploy-on-labtrop](https://github.com/lageIBUSP/notaR/actions/workflows/deploy-on-labtrop.yml/badge.svg)](https://github.com/lageIBUSP/notaR/actions/workflows/deploy-on-labtrop.yml)
Um sistema para notas automatizadas em cursos que utilizam a linguagem R

O notaR é um sistema para correção automática de exercícios em linguagem R, armazenamento e 
visualização das notas resultantes. Ele é um software colaborativo, desenvolvido em linguagens de código aberto.

Se você for usar o notaR, cite como:
Chalom, A., Salles, M., Prado, P. I. & Oliveira, A. Adalardo de (2012). notaR - Um sistema para notas automatizadas em cursos que utilizam a linguagem R (Version 2.0), from https://github.com/lageIBUSP/notaR.

## Usando o notaR

O notaR é usado hoje em cursos oferecidos pela Universade de São Paulo (USP), Universidade Estadual Paulista (UNESP),
Instituto Nacional de Pesquisas da Amazônia (INPA), Universidade Federal do Rio Grande do Norte (UFRN):
* [Introdução à Linguagem R](http://www.ecologia.ib.usp.br/bie5782/doku.php)
* [Modelagem Estatística para Ecologia e Recursos Naturais](http://cmq.esalq.usp.br/BIE5781/doku.php)

Para acessar a plataforma online usada por estes cursos, clique [aqui](http://notar.ib.usp.br/).
Caso queira utilizar essa plataforma para um curso com os alunos cadastrados e com registros de nota, encaminhe email para <a href= "mailto:aleadalardo@gmail.com?subject=Cadastro notaR">Alexandre Adalardo de Oliveira</a>.

## Documentação

A documentação do sistema notaR está disponível em um sistema wiki. Clique [aqui](https://github.com/lageIBUSP/notaR/wiki).

## Instalando o notaR

O notaR 4.0 é instalado através do [Docker](https://www.docker.com/). O Docker mantém cada parte do notaR isolada em um contêiner, separada do sistema operacional. Isso permite que o notaR funcione exatamente igual em qualquer sistema, mesmo que o sistema não tenha PHP, MySql ou R. Por isso, a única ferramente necessária para instalar o notaR é o próprio Docker. Instale o Docker no seu sistema antes de começar a instalação (instruções [aqui](https://docs.docker.com/get-docker/)).

Para instalar uma nova plataforma notaR, siga os seguintes passos (nota: alguns desses comando só funcionam em linux):

0. crie um usuário para o notaR, com id 1337 e pertencente ao grupo `docker` (para facilitar, esse usuário pode se chamar `docker`):
```
sudo user add -u 1337 docker
```
1. Faça login com esse usuário:
```
sudo su docker
```
2. clone o repositório no seu servidor
3. crie o arquivo ```.env``` a partir do ```.env.example```, com as informações do seu servidor. Use ```APP_ENV=local``` para desenvolvimento e ```APP_ENV=production``` para produção. 
4. rode o script ```deploy.sh```
5. gere uma chave e registre ela no seu ```.env```:
```
docker exec -t notar_app_1 php artisan key:generate
```
6. crie um usuário admin com login admin@notar.br:
```
docker exec -t notar_app_1 php artisan migrate:admin novasenha
``` 
7. se você tiver um banco de dados do notaR-legacy e quiser importar os exercícios, rode o comando
```
docker exec -t notar_app_1 php artisan migrate:legacy
```

## Licença de uso
O código fonte do notaR está disponível sob licença GPLv3.

