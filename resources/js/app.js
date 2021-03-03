/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');

    global.moment = require('moment');
    require('tempusdominus-bootstrap-4');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Code for our application. This function will ony be called after the page has finished loading:
$(document).ready(() => {
    $('.delete').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Tem certeza que quer deletar? Essa ação não pode ser desfeita.')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });

    $('.datetimepicker-input').datetimepicker();

    $('.clear-input').click(function() {
        $(this).closest('td').find('input').val('');
    });
});
