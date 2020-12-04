$(document).ready(function() {

    $("#loginForm").validate({
        rules: {
            "login": {
                "required": true,
                "nowhitespace": true,
                "alphanumeric": true
            },
            "password": {
                "required": true,
                "nowhitespace": true,
                "alphanumeric": true

            }
        },
        messages : {
            "login": {
                "required": "El campo no puede estar vacío",
                "alphanumeric": "El campo debe ser alfanumerico.",
                "nowhitespace": "El campo no puede ser un espacio en blanco"
            },
            "password": {
                "required": "El campo no puede estar vacío",
                "alphanumeric": "El campo debe ser alfanumerico.",
                "nowhitespace": "El campo no puede ser un espacio en blanco"
            }
        },
        errorElement: "label"
    });
});