$(document).ready(function() {
    $("#loginForm").validate({
        rules: {
            login: {
                nowhitespace: true,
                alphanumeric: true,
                maxLength: 12,
                minLength: 1,
                required: true
            },
            password: {
                nowhitespace: true,
                alphanumeric: true,
                maxLength: 64,
                minLength: 1,
                required: true
            }
        },
        errorClass:  'fieldError',
        onkeyup:     false,
        onblur:      false,
        errorElement:'label',
        messages : {
            login: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 12 caracteres.",
                alphanumeric: "El campo debe ser alfanumerico.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            password: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 64 caracteres.",
                alphanumeric: "El campo debe ser alfanumerico.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            }
        },

    });

    $("#botonLogin").click(function(){
        $("#loginForm").submit();
        return false;
    });
});