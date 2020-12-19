$(document).ready(function() {
    $("#addEdificioForm").validate({
        rules:{
            "nombre_edif": {
                "required": true,
                "lettersonly": true
            },"num_plantas": {
                "nowhitespace": true,
                "digit": true
            },
            "direccion_edif": {
                "required": true,
                "lettersonly": true
            },"agrup_edificio": {
                "nowhitespace": true,
                "digit": true
            },"telef_edif": {
                "nowhitespace": true,
                "digit": true,
                "required": true
            },
            messages:{
                "nombre_edif": {
                    "required": "El campo no puede estar vacío",
                    "lettersonly": "El campo debe ser alfabético"
                },"num_plantas": {
                    "nowhitespace": "El campo no puede ser un espacio en blanco",
                    "digit": "El campo debe estar formado por números."
                },"direccion_edif": {
                    "required": "El campo no puede estar vacío",
                    "lettersonly": "El campo debe ser alfabético"
                },"agrup_edificio": {
                    "nowhitespace": "El campo no puede ser un espacio en blanco",
                    "digit": "El campo debe estar formado por números."
                }
            },
            errorElement: "label"
            }
        });

    $("#botonAddEdificio").click(function(){
        $("#addEdificioFormForm").submit();
        return false;
    });

    $("#botonAtrasAddEdificio").click(function(){
        window.location.href = "../Controllers/AGRUPACION_Controller.php?action=showall";
        return false;
    });
});

