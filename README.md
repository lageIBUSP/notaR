# notaR
[![deploy-on-labtrop](https://github.com/lageIBUSP/notaR/actions/workflows/deploy-on-labtrop.yml/badge.svg)](https://github.com/lageIBUSP/notaR/actions/workflows/deploy-on-labtrop.yml)
Um sistema para notas automatizadas em cursos que utilizam a linguagem R

O notaR é um sistema para correção automática de exercícios em linguagem R, armazenamento e
visualização das notas resultantes. Ele é um software colaborativo, desenvolvido em linguagens de código aberto.

Se você for usar o notaR, cite como:
Chalom, A., Salles, M., Prado, P. I. & Oliveira, A. Adalardo de (2012). notaR - Um sistema para notas automatizadas em cursos que utilizam a linguagem R (Version 2.0), from https://github.com/lageIBUSP/notaR.

## Usando o notaR

O notaR é usado hoje em cursos oferecidos pela Universidade de São Paulo (USP), Universidade Estadual Paulista (UNESP),
Instituto Nacional de Pesquisas da Amazônia (INPA), Universidade Federal do Rio Grande do Norte (UFRN), abaixo o link para o material de duas destas disciplinas:
* [Introdução à Linguagem R](http://ecor.ib.usp.br)
* [Modelagem Estatística para Ecologia e Recursos Naturais](http://cmq.esalq.usp.br/BIE5781/doku.php)

Para acessar a plataforma online usada por estes cursos, clique [aqui](http://notar.ib.usp.br/).
Caso queira utilizar essa plataforma para um curso com os alunos cadastrados e com registros de nota, encaminhe email para <a href= "mailto:aleadalardo@gmail.com?subject=Cadastro notaR">Alexandre Adalardo de Oliveira</a>.

## Documentação

A documentação do sistema notaR está disponível em um sistema wiki. Clique [aqui](https://github.com/lageIBUSP/notaR/wiki).

## Instalando o notaR

O notaR 4.0 é instalado através do [Docker](https://www.docker.com/). O Docker mantém cada parte do notaR isolada em um contêiner, separada do sistema operacional. Isso permite que o notaR funcione exatamente igual em qualquer sistema, mesmo que o sistema não tenha PHP, MySql ou R. Por isso, a única ferramente necessária para instalar o notaR é o próprio Docker. Instale o Docker no seu sistema antes de começar a instalação (instruções [aqui](https://docs.docker.com/get-docker/)).

Para instalar uma nova plataforma notaR, siga os seguintes passos (nota: alguns desses comando só funcionam em linux):

1. Clone este repositório no seu servidor
2. Crie o arquivo ```.env``` a partir do ```.env.example```, com as informações do seu servidor. Use ```APP_ENV=local``` para desenvolvimento e ```APP_ENV=production``` para produção.
3. Edite os valores de `WWWUSER` e `WWWGROUP` de acordo com o user id do seu usuário
4. Rode o script ```deploy.sh```
5. Gere uma chave e registre ela no seu ```.env```:
```
docker exec -t notar_app_1 php artisan key:generate
```
6. Crie o novo banco de dados:
```
docker exec -t notar_app_1 php artisan migrate
```
7. Crie um usuário admin com login admin@notar.br:
```
docker exec -t notar_app_1 php artisan migrate:admin novasenha
```

## Rodando os testes de integração

**ATENÇÃO: ESSES TESTES DESTROEM SEU BANCO DE DADOS LOCAL. NÃO RODE EM PRODUÇÃO**

Os testes foram escritos para ajudar no desenvolvimento da plataforma. Todos os dados do banco de dados são destruídos antes dos testes, para evitar conflitos. Os testes foram desenvolvidos em [Cypress](https://www.cypress.io/) usando o pacote de cypress para laravel [laracasts/cypress](https://github.com/laracasts/cypress). Alguns arquivos foram gerados automaticamente usando o comanto `php artisan cypress:boilerplate`.

Para testar e desenvolver a plataforma, instale o notaR no seu ambiente local para testes, seguindo o guia acima. Além disso, é necessário instalar o `npm`. Com isso, para abrir a interface gráfica do `cypress`, basta executar o seguinte comando:

```
npx cypress run
```

Na interface gráfica, selecione **E2E Testing**, e um browser à sua escolha.

Para mais detalhes, consulte a [documentação do Cypress](https://docs.cypress.io/).

## Licença de uso
O código fonte do notaR está disponível sob licença GPLv3.
