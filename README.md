# notaR
Um sistema para notas automatizadas em cursos que utilizam a linguagem R

O notaR é um sistema para correção automática de exercícios em linguagem R, armazenamento e 
visualização das notas resultantes. Ele é um software colaborativo, desenvolvido em linguagens de código aberto.

Se você for usar o notaR, cite como:
Chalom, A., Salles, M., Prado, P. I. & Adalardo, A. (2012). notaR - Um sistema para notas automatizadas em cursos que utilizam a linguagem R (Version 2.0), from https://github.com/lageIBUSP/notaR.

## Usando o notaR

O notaR é usado hoje em cursos oferecidos pela Universade de São Paulo (USP),
Instituto Nacional de Pesquisas da Amazônia (INPA) e Universidade Federal do Rio Grande do Norte (UFRN):
* [Introdução à Linguagem R](http://www.ecologia.ib.usp.br/bie5782/doku.php)
* [Modelagem Estatística para Ecologia e Recursos Naturais](http://cmq.esalq.usp.br/BIE5781/doku.php)

Para acessar a plataforma online usada por estes cursos, clique [aqui](http://www.lage.ib.usp.br/rserve/).

## Documentação

A documentação do sistema notaR está disponível em um sistema wiki. Clique [aqui](https://github.com/lageIBUSP/notaR/wiki).

## Instalando o notaR

O notaR 4.0 é instalado através do [Docker](https://www.docker.com/). O Docker mantém cada parte do notaR isolada em um contêiner, separada do sistema operacional. Isso permite que o notaR funcione exatamente igual em qualquer sistema, mesmo que o sistema não tenha PHP, MySql ou R. Por isso, a única ferramente necessária para instalar o notaR é o próprio Docker. Instale o Docker no seu sistema antes de começar a instalação (instruções [aqui](https://docs.docker.com/get-docker/)).

Para instalar uma nova plataforma notaR:

0. crie um usuário para o notaR, com id 1337. Faça login com esse usuário antes de tudo.
1. clone o repositório no seu servidor
2. crie o arquivo ```.env``` a partir do ```.env.example```, com as informações do seu servidor. Use ```APP_ENV=local``` para desenvolvimento e ```APP_ENV=production``` para produção. 
3. rode o script ```deploy.sh```
4. gere uma chave e registre ela no seu ```.env``` com ```sail artisan key:generate```
5. use  ```sail artisan migrate:admin novasenha``` para criar um usuário admin com login admin@notar.br.

## Licença de uso
O código fonte do notaR está disponível sob licença GPLv3.

