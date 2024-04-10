describe('Visit page as a guest', () => {
    it('shows a homepage', () => {
        cy.visit('/')

        cy.contains('notaR')
    });
    it('shows exercicios link', () => {
        cy.visit('/')

        cy.contains('Exercícios').click()
        cy.url().should('include', '/exercicio')
    });
});
