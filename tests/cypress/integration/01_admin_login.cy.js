describe('Login test', () => {
  const email = 'admin@notar.br'
  const password = 'novasenha'

  before(() => {
    const artisan = './vendor/bin/sail artisan'
    // reset and seed the database prior to every test
    // seed a user in the DB that we can control from our tests
    cy.exec(`${artisan} migrate:fresh`)
    cy.exec(`${artisan} migrate:admin ${password}`)
    cy.exec(`${artisan} db:seed`)

  })

  it('Log in via login form', function () {
    cy.visit('/')

    // Login link exists
    cy.contains('Entrar').click()
    // Redirects to login
    cy.url().should('include', '/login')

    // Fill up form
    cy.get('input[name=email]').type(email)
    // {enter} causes the form to submit
    cy.get('input[name=password]').type(`${password}{enter}`)

    // Should be redirected to user page
    cy.url().should('include', '/user/1')

    // UI should reflect this user being logged in
    cy.get('h1').should('contain', 'Admin')

    // Can see turmas
    cy.contains('Cursos').click()
    cy.url().should('include', '/curso')
    cy.contains('Cursos')
    cy.go('back')

    // Can see Users
    cy.contains('Usuários').click()
    cy.url().should('include', '/user')
    cy.contains('Usuários')
    cy.go('back')

    // Can see Exercícios
    cy.contains('Exercícios').click()
    cy.url().should('include', '/exercicio')
    cy.contains('Exercícios')
    cy.go('back')

    // Can see Arquivos
    cy.contains('Arquivos').click()
    cy.url().should('include', '/arquivo')
    cy.contains('Arquivos')
    cy.go('back')

    // Can see Relatórios
    cy.contains('Relatórios').click()
    cy.url().should('include', '/relatorio')
    cy.contains('Relatórios')
    cy.go('back')

    // Can see Impedimentos
    cy.contains('Impedimentos').click()
    cy.url().should('include', '/impedimento')
    cy.contains('Impedimentos')
    cy.go('back')
  })
})
