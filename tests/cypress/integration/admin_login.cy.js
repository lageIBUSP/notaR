describe('Login test', () => {
  const email = 'admin@notar.br';
  const password = 'novasenha';

  beforeEach(() => {
    const artisan = './vendor/bin/sail artisan'
    // reset and seed the database prior to every test
    // seed a user in the DB that we can control from our tests
    cy.exec(`${artisan} migrate:fresh`)
    cy.exec(`${artisan} migrate:admin ${password}`)

  })

  it('Log in via login form', function () {
    cy.visit('/')

    // Login link exists
    cy.contains('Entrar').click();
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
  })
})
