$(document).ready(function() {
    $("#loginForm").validate({
        rules: {
            login: {
                required: true,
                minLength: 1,
                maxLength: 12
            },
            password: {
                required: true,
                minLength: 1,
                maxLength: 64
            }
        },
        messages : {
            login: {
                required : "El campo es obligatorio.",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 12 caracteres.",
                alphanumeric: "El campo debe ser alfanumerico."
            },
            password: {
                required : "El campo es obligatorio.",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 64 caracteres."
            }
        },

    });
});