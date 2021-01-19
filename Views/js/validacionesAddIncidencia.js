$(document).ready(function (){
   $('#addIncidenciaForm').validate({
      rules: {
         "autor": {
            "required" : true,
            "pattern": '^[a-zA-Z0-9á-ú ]+$'
         },
         "espacio_id": {
            "required" : true
         },
         "descripcion_incid": {
            "required" : true,
            "pattern": '^[a-zA-Z0-9á-ú ]+$'
         }
      },
      messages : {
         "autor" : {
            "required" : "Campo obligatorio",
            "pattern" : "Introduce letras y/o numeros"
         },
         "espacio_id": {
            "required": "Campo obligatorio"
         },
         "descripcion_incid": {
            "required" : "Campo obligatorio",
            "pattern" : "Introduce letras y/o numeros"
         }
      }
   });
});