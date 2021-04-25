require('./bootstrap');
require( 'datatables.net' );
require( 'datatables.net-bs4' );
require( 'datatables.net-responsive-bs4' );
require( 'bootstrap-select' );
window.$ = window.jQuery = require( 'jquery' );

$(document).ready(function() {
    $('#data_table').DataTable({
        responsive: true,
        order: []
    });
} );
