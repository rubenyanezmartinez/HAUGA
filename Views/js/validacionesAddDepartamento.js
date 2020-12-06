$(document).ready(function() {
    $("#addDepartamentoForm").validate({
        rules: {
            "nombre_depart": {
                "required": true,
                "lettersonly": true
            },
            "area_conc_depart": {
                "required": true,
                "lettersonly": true
            },
            "codigo_depart": {
                "nowhitespace": true,
                "alphanumeric": true,
                "required": true
            },
            "edificio_depart": {
                "required": true
            },
            "telef_depart": {
                "nowhitespace": true,
                "digit": true,
                "required": true
            },
            "responsable_depart": {
                "required": true
            },
            "email_depart": {
                "nowhitespace": true,
                "email": true,
                "required": true
            }
        },
        messages : {
            "nombre_depart": {
                "required": "El campo no puede estar vacío",
                "lettersonly": "El campo debe ser alfabético"
            },
            "area_conc_depart": {
                "required": "El campo no puede estar vacío",
                "lettersonly": "El campo debe ser alfabético"
            },
            "codigo_depart": {
                "required": "El campo no puede estar vacío",
                "alphanumeric": "El campo debe ser alfanumerico.",
                "nowhitespace": "El campo no puede ser un espacio en blanco"
            },
            "edificio_depart": {
                "required": "El campo no puede estar vacío"
            },
            "telef_depart": {
                "required": "El campo no puede estar vacío",
                "digit": "El campo debe estar formado por números.",
                "nowhitespace": "El campo no puede ser un espacio en blanco"
            },
            "responsable_depart": {
                "required": "El campo no puede estar vacío"
            },
            "email_depart": {
                "required": "El campo no puede estar vacío",
                "email": "El campo debe ser un email.",
                "nowhitespace": "El campo no puede ser un espacio en blanco"
            }
        },
        errorElement: "label"

    });

    jQuery.validator.addMethod('lettersonly', function(value, element) {
        return this.optional(element) || /^[a-z áãâäàéêëèíîïìóõôöòúûüùçñ]+$/i.test(value);
    }, "Letters and spaces only please");

    $("#botonAddDepartamento").click(function(){
    $("#addDepartamentoForm").submit();
    return false;
    });

    $("#botonAtrasAddDepartamento").click(function(){
        window.location.href = "../Controllers/Departamento_Controller.php?action=showall";
        return false;
    });
});