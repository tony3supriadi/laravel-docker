$(document).ready(function() {
    var date = new Date();

    $('.daterange').daterangepicker({
        locale: {
            format: 'DD MMM YYYY'
        }
    });
})