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
# Usa variavel global PATH (definida no PHP?)  
corretoR <- function (id.exerc, texto) {
		# Definicoes iniciais
		corrEnv <- new.env()
    	# copia todos os arquivos de dados para que possam ser usados pelo corretor
    	# file.copy(dir(path=paste0(PATH, "/files"), full.names=T), ".") TODO 
		# Funcoes dsiponiveis dentro do ambiente de correcao
		# eval(parse(file=paste0(PATH,"/acessorias.R")), envir=corrEnv)
		# TO DO: mover eq para acessorias
		assign("eq", function(a, b) isTRUE(all.equal(a,b, tol=1e-7, check.attributes=FALSE)), envir=corrEnv)

		testes <- dbGetQuery(con,
							 paste("SELECT condicao FROM testes
								   WHERE exercicio_id=", id.exerc,
								   " ORDER BY id ASC", sep=""));
		precondi <- dbGetQuery(con, 
							   paste("SELECT precondicoes FROM exercicios 
									 WHERE id=", id.exerc, sep=""));

		# Executa as precondicoes
		if(!no.results(precondi)) eval(parse(text=precondi), envir=corrEnv);

		# Executa o texto da resposta
		# try pega erros de sintaxe
		getError <- try(eval(parse(text=texto), envir=corrEnv));
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

# Gera um output formatado em HTML a respeito de um exercicio corrigido
relatorioNota <- function (id.exerc, nota, texto) {
		# Definicoes iniciais
		dica <- dbGetQuery (con,
							paste("SELECT dica FROM testes
								  WHERE exercicio_id = ", id.exerc,
								  " ORDER BY id ASC ", sep=""));
		peso <- dbGetQuery (con,
							paste("SELECT peso FROM testes
								  WHERE exercicio_id = ", id.exerc,
								  " ORDER BY id ASC ", sep=""));
		notaMax <-dim(dica)[1]
		Rel <- "";
		if (! is.null(nota) && sum(nota) != notaMax) { 
			Rel <- paste(Rel, "<font color='#8c2618'>ATEN&Ccedil;&Atilde;O!</font><br>")
			# Envia a primeira mensagem de erro
			primeiro.erro <- min(which(!nota))
			Rel <- paste(Rel, "<br>", dica[primeiro.erro,1], 
					 "<br>Corrija essa condi&ccedil;&atilde;o para continuar a corre&ccedil;&atilde;o.",	sep="");
		}
		if (is.null(nota)) {
				Rel <- paste(Rel, "<p>Cuidado! Seu exerc&iacute;cio n&atilde;o executou. Ser&aacute; que ele cont&eacute;m algum
							  erro de sintaxe? Veja dicas no linque de \"ajuda\" para corrigir os problemas.</p>", sep="");
		} else { Rel <- paste(Rel, "<p>Seu aproveitamento: <b>", round(100*weighted.mean(nota, t(peso))),"%</b>.</p>", sep=""); }
#		Rel <- paste(Rel, "<p>Sua resposta:<br>", paste(texto, collapse="<br>"),"</p>", sep="");
		return(Rel)
}

# gravarNota recebe
# id.aluno (pode ser NULL, no caso de ouvintes)
# numero.aula, numero.exercicio
# nota: logical vector contendo o resultado da correcao
# texto: resposta dada pelo aluno
# Valor de retorno: char, especificando mensagem de sucesso ou erro 
# na insercao da nota
gravarNota <- function (id.aluno="", id.exerc, texto, nota = corretoR(id.exerc, texto)) {
		if (id.aluno =="") {
			return ("<p>Fa&ccedil;a login para gravar a sua nota.</p>");
		}
		# Definicoes iniciais
		Date <- format(Sys.time(), "%F %R");

		peso <- dbGetQuery (con,
				paste("SELECT peso FROM testes
				WHERE exercicio_id = ", id.exerc,
				" ORDER BY id ASC ", sep=""));

		# Escapa os single quotes do texto
		if (is.null(nota)) nota <-rep(0, length(t(peso)));
		valornota = round(100*weighted.mean(nota, t(peso)))
		insert = paste0("INSERT INTO notas (user_id, exercicio_id, created_at, nota) 
					VALUES (",id.aluno,",",id.exerc,",'",Date,"',",valornota, ")");
		res <- dbSendQuery(con, insert);
		Rel <- paste("<p>Nota cadastrada!</b>.", sep="");
		
		return (paste(Rel, "</p>"));
}

# Recebe o exercicio, corrige, grava a nota e gera um output formatado em HTML
notaR <- function (id.aluno, id.exerc, arquivo) {
		texto <- readLines(arquivo, encoding="utf8");
		nota <- corretoR (id.exerc, texto);
		# Tenta de novo com charset latin1:
		if (is.null(nota)) {
			texto <- readLines(arquivo, encoding="latin1");
			nota <- corretoR (id.exerc, texto);
		}
		# Grava a nota no banco:
		notaGravada <- gravarNota(id.aluno, id.exerc, texto, nota)
		# Gera o relatorio de notas:
		Rel <- relatorioNota(id.exerc, nota, texto);
		return(paste(Rel, notaGravada,sep=""))
}
# Exemplos: 
# con <- connect('notaR', 'notaRPW', 'notaR')
# PATH <- '/var/www/notaR/'
# notaR(1, 1,"xpto.R")