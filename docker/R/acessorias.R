# Compara dois objetos com tolerância para diferenças de floating point
eq <- function(a, b) {
    isTRUE(all.equal(a,b, tol=1e-7, check.attributes=FALSE))
}

# Usado para "proibir" o uso de uma função. Use `proibir("var")` nas pre-condicoes
# E `proibidas()` como um dos testes
proibir <- function(funcao) {
	assign(funcao, function(...) {
		assign("chamadas.proibidas", TRUE, envir=globalenv());
		parent.f <- get(funcao, envir=globalenv());
		return (parent.f(...));
	}, envir=parent.frame())
}

proibidas <- function() {
    return( !get("chamadas.proibidas", envir=globalenv()))
}

# Necessário para bom funcionamento das funções acima
assign("chamadas.proibidas", FALSE, envir=globalenv());