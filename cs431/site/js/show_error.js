$(document).ready(function() {
    $('#nameTaken').modal('show');
    $('#nameTaken').on('shown', function() {
        $('#button').focus();
    });
});
