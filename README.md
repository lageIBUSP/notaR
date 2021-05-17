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


Para instalar uma nova plataforma notaR: 
1. clone o repositório no seu servidor
2. crie o arquivo ```.env``` a partir do ```.env.example```, com as informações do seu servidor
3. rode o script ```deploy.sh```
4. se quiser importar exercícios de um banco de dados de notaR-legacy, rode o comando de artisan ```artisan migrate:legacy```
5. use o comando de artisan ```artisan migrate:admin novasenha``` para criar um usuário admin com login admin@notar.br.

*NOTE* que a versão atual no Github é uma versão de desenvolvimento (ou seja, warnings e erros são 
mostrados sem filtros ao usuário), enquanto versões na página 
de [Releases](https://github.com/lageIBUSP/notaR/releases) são adequadas para produção.

## Licença de uso
O código fonte do notaR está disponível sob licença GPLv3.

