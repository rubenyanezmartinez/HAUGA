$(document).ready(function (){
    $("#addEspacioForm").validate({
        rules : {
            "nombre_esp": {
                'required' : true,
                'pattern' : '^[a-zA-Z0-9á-ú .-]+$'
            },
            'tarifa_esp':{
                'required' : true,
                'integer': true,
                'min' : 0
            },
            'categoria_esp' : {
                'required' : true
            },
            'edificio_esp' : {
                'required' : true,
            },
            'planta_esp' : {
                'required' : true,
                'integer' : true,
            },
            'imagen_espacio' : {
                'required' : esNuevo,
                'accept' : "image/*"
            }
        },
        messages : {
            "nombre_esp": {
                'required' : 'El campo no puede estar vacío',
                'pattern' : 'Formato incorrecto'
            },
            'tarifa_esp':{
                'required' : 'El campo no puede estar vacío',
                'integer' : 'Solo números sin decimales',
                'min' : 'Solo números positivos'
            },
            'categoria_esp' : {
                'required' : 'El campo no puede estar vacío'
            },
            'edificio_esp' : {
                'required' : 'El campo no puede estar vacío',
            },
            'planta_esp' : {
                'required' : 'El campo no puede estar vacío',
                'integer' : 'Solo números sin decimales',
                'max' : 'Planta no válida',
                'min' : 'Planta no válida'
            },
            'imagen_espacio' : {
                'required' : 'El campo no puede estar vacío',
                'accept' : "Archivos permitidos: .PNG,.JPEG,.jpg"
            }
        }
    });
});

function cambiarEdificio(){
    $('#planta_esp').attr('max', arrayPlantas[$('#edificio_esp').val()] - 1);
    $('#planta_esp').attr('min', 1 - arrayPlantas[$('#edificio_esp').val()]);
}