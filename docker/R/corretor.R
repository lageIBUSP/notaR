## ## ## Corretor automatico
# Usa uma conexao "global" con
connect <- function (dbuser, dbpass, dbname) {
		require(RMySQL)
		# Conexao com o banco de dados
		try(dbDisconnect(con), silent=TRUE)
		con<- dbConnect(MySQL(), user=dbuser, password=dbpass, dbname=dbname, host='mysql')
		return (con);
}
# Construida na chamada PHP como
# con <- connect($DBUSER, $DBPASS, $DBNAME)

# Funcao acessoria para testar se um objeto MySQL nao tem resultados
no.results <- function(object) {
  length(object[,1]) == 0
}

# corretoR recebe:
# texto
# E devolve um um vector logico com o resultado dos testes
# Caso o codigo tenha erros de sintaxe, retorna NULL
corretoR <- function (precondi, testes, texto) {
		# Definicoes iniciais
		corrEnv <- new.env()
		# Funcoes disponiveis dentro do ambiente de correcao
		eval(parse(file=paste0("/usr/local/src/notar/acessorias.R")), envir=corrEnv)

		# Executa as precondicoes
		if(!no.results(precondi)) eval(parse(text=precondi), envir=corrEnv);

		# Executa o texto da resposta
		getError <- try(eval(
			c(parse(text=texto),"TRUE"), # Evita que o codigo retorne matrizes
			envir=corrEnv
		));
		# try pega erros de sintaxe
		if (class(getError) == "try-error") return (NULL);

		# Executa os testes cadastrados, sequencialmente
		notaMax <-dim(testes)[1]
		notas <- rep(FALSE, notaMax)
		for (i in 1:notaMax) {
				# A avaliacao pode retornar TRUE, FALSE ou erro
				# No momento, erro esta sendo tratado como FALSE
				# Edit fev 2013:
				# O [1] no final tem a funcao de evitar condicoes com comprimento 0.
				# Agora essas condicoes se tornam [1] NA, que serao transformados em FALSE abaixo
				notas[i] <- (try(eval(parse(text=testes[i,1]), envir=corrEnv))[1] == TRUE)[1];
		}
		notas[is.na(notas)] <- FALSE
		return(notas);
}

# Recebe o exercicio, transforma o texto em string, corrige, e retorna o vetor de true/false para os testes passados
notaR <- function (id.exerc, arquivo) {
	# import files
	file.copy(list.files("/arquivos/", recursive=TRUE, full.names=TRUE), ".");
	# Limits memory usage
	rlimit_as(1e9);
	rlimit_cpu(15);
	# Read file
	texto <- readLines(arquivo, encoding="utf8");
	# Get exercicio
	testes <- dbGetQuery(con,
							paste("SELECT condicao FROM testes
									WHERE exercicio_id=", id.exerc,
									" ORDER BY id ASC", sep=""));
	precondi <- dbGetQuery(con,
								paste("SELECT precondicoes FROM exercicios
									WHERE id=", id.exerc, sep=""));

	# Run corretor
	nota <- corretoR (precondi, testes, texto);
	# Tenta de novo com charset latin1:
	if (is.null(nota)) {
		texto <- readLines(arquivo, encoding="latin1");
		nota <- corretoR (precondi, testes, texto);
	}
	# Delete files
	unlink("*", recursive=TRUE);
	return (nota);
}

# Exemplos:
# con <- connect('notaR', 'notaRPW', 'notaR')
# corretoR(1, "y<-1;x<-2")
# ou
# notaR(1, "/tmp/file.R")
