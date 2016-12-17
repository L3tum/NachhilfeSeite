
toastr.options = {
    "closeButton": true,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$(document).foundation();
$(document).foundation();



$("#login-form")
    .on("forminvalid.zf.abide", function(ev) {
        toastr.error('Login fehlgeschlagen!');
    })
    .on("submit", function(ev) {
        ev.preventDefault();
        $.ajax("ajax/loginForm.php");
    });


