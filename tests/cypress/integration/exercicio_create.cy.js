describe('Login test', () => {
  const email = 'admin@notar.br';
  const password = 'novasenha';

  const title = 'Exercício 1'
  const description = 'Siga as instruções com atenção. Some x e y e salve na variável x, sem usar sum.'
  const preconds = 'x <- 1; y <- 2; proibir(\'sum\')'
  const [cond1, dica1] = ['proibidas()', 'no sum']
  const [cond2, dica2] = ['x == 3', 'x tem que ser a soma de x e y']

  before(() => {
    const artisan = './vendor/bin/sail artisan'
    // reset and seed the database prior to every test
    // seed a user in the DB that we can control from our tests
    cy.exec(`${artisan} migrate:fresh`)
    cy.exec(`${artisan} migrate:admin ${password}`)

  })

  beforeEach('Log in via login form', function () {
    cy.visit('/login')

    // Fill up form
    cy.get('input[name=email]').type(email)
    // {enter} causes the form to submit
    cy.get('input[name=password]').type(`${password}{enter}`)
  })

  it('Create exercicio', function () {
    // Can see Exercícios
    cy.contains('Exercícios').click()
    cy.url().should('include', '/exercicio')
    cy.contains('Exercícios')

    cy.contains('Cadastrar exercicio').click()

    cy.contains('Criar novo exercício')

    // Fill form
    cy.get('input[name="name"]').type(title)
      .should('have.value', title)
    cy.get('textarea[name="description"]').type(description)
      .should('have.value', description)
    cy.get('textarea[name="precondicoes"]').type(preconds)
      .should('have.value', preconds)

    // Cond 1
    cy.get('input[name="condicoes[]"]').type(cond1)
      .should('have.value', cond1)
    cy.get('input[name="dicas[]"]').type(dica1)
      .should('have.value', dica1)
    cy.get('input[name="pesos[]"]').type('1')
      .should('have.value', '1')

    cy.get('i.add-row').click()
    cy.get('tr:nth-child(2) input[name="condicoes[]"]').type(cond2)
      .should('have.value', cond2)
    cy.get('tr:nth-child(2) input[name="dicas[]"]').type(dica2)
      .should('have.value', dica2)
    cy.get('tr:nth-child(2) input[name="pesos[]"]').type('1')
      .should('have.value', '1')

    cy.contains('button', 'Criar').click()

    // Should redirect to exercicio
    cy.url().should('include', '/exercicio/1')
  })
  it('Responder ao exercício', function () {
    cy.visit('/exercicio/1')

    cy.contains('h1', title)
    cy.contains(description)
    cy.contains('Editar este exercício')
    cy.contains('Exportar este exercício')
    cy.contains('Resposta')

    // Send valid answer
    cy.get('div#editor').type('x <- x + y{enter}')
    cy.contains('Sua nota: 100.0%')
  })

  it('Responder ao exercício com resposta errada', function () {
    cy.visit('/exercicio/1')
    // Send half-valid answer
    cy.get('div#editor').type('x <- sum(x,y){enter}')
    cy.contains(dica1)
    cy.contains('Sua nota: 50.0%')
  })

  it('Responder ao exercício com erro de sintaxe', function () {
    cy.visit('/exercicio/1')
    // Send invalid answer
    cy.get('div#editor').type('something{enter}')
    cy.contains('erro')
    cy.contains('Sua nota: 0.0%')
  })
})
