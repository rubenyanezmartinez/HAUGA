$(document).ready(function(){
    $("#addAgrupForm").validate({
        rules: {
            "nombre_agrup": {
                'required': true,
                'pattern': '^[a-zA-Z0-9á-ú ]+$'
            },
            "ubicacion_agrup": {
                'required': true,
                'pattern': '^[a-zA-Z0-9á-ú .,]+$'
            }
        },
        messages : {
            'nombre_agrup': {
                'required': 'El campo no puede estar vacío',
                'pattern': 'Introduce letras y/o números'
            },
            'ubicacion_agrup': {
                'required': 'El campo no puede estar vacío',
                'pattern': 'Introduce letras y/o números'
            },
        }
    });
});