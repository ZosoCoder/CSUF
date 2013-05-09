function user_taken() {
    $('#nameTaken').modal('show');
    $('#nameTaken').on('shown', function() {
        $('#button').focus();
    });
}

function register_success() {
    $('#registered').modal('show');
    $('#registered').on('shown', function() {
        $('#button').focus();
    });
}
