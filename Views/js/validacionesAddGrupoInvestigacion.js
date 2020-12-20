$(document).ready(function(){
    $("#addGrupoInvestigacionForm").validate({
        rules: {
            "nombre_grupo": {
                "required": true,
                "lettersonly" : true
            },
            "area_conoc_grupo": {
                "required": true,
                "lettersonly": true
            },
            "telef_grupo": {
                "nowhitespace": true,
                "digit": true,
                "required": true
            },
            "responsable_grupo": {
                "required": true
            },
            "email_grupo": {
                "nowhitespace": true,
                "email": true,
                "required": true
            },
            "lineas_investigacion": {
                "required": true,
                "pattern": '^([a-zA-Zá-ú ]+,?)+[a-zA-Zá-ú ]$'
            }
        },
        messages : {
            "nombre_grupo": {
                "required": "El campo no puede estar vacío",
                "lettersonly" : "El cambo debe ser alfabético"
            },
            "area_conoc_grupo": {
                "required": "El campo no puede estar vacío",
                "lettersonly": "El cambo debe ser alfabético"
            },
            "telef_grupo": {
                "nowhitespace": "Introduce un teléfono válido",
                "digit":"Introduce un teléfono válido",
                "required": "El campo no puede estar vacío"
            },
            "responsable_grupo": {
                "required": "El campo no puede estar vacío"
            },
            "email_grupo": {
                "nowhitespace": "Introduce un email válido",
                "email": "Introduce un email válido",
                "required": "El campo no puede estar vacío"
            },
            "lineas_investigacion": {
                "required": "El campo no puede estar vacío",
                "pattern": "Introduce las líneas de investigación separadas por comas"
            }
        }
    });
});