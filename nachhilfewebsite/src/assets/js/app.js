
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
$(document)
    .foundation()
    .on("forminvalid.zf.abide", function(ev,frm) {

        switch(ev.target) {
            case $("#login-form")[0]:
                toastr.error('Login fehlgeschlagen!');
                break;
        }
        
    })

