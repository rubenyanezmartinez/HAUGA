$(document).ready(function() {

    $("#div_depart_usuario").hide();
    $("#div_grupo_usuario").hide();
    $("#div_centro_usuario").hide();
    $("#div_nombre_puesto").hide();
    $("#div_nivel_jerarquia").hide();

    if($( "#afiliacion option:selected" ).val() == "DOCENTE"){
        $("#div_depart_usuario").show();
        $("#div_centro_usuario").show();
    }else if($( "#afiliacion option:selected" ).val() == "INVESTIGADOR"){
        $("#div_grupo_usuario").show();
    }else if($( "#afiliacion option:selected" ).val() == "ADMINISTRACION"){
        $("#div_nombre_puesto").show();
        $("#div_nivel_jerarquia").show();
    }

    $("#afiliacion").on('change', function() {
        if($(this).val() == "DOCENTE"){
            $("#div_depart_usuario").show();
            $("#div_grupo_usuario").hide();
            $("#div_centro_usuario").show();
            $("#div_nombre_puesto").hide();
            $("#div_nivel_jerarquia").hide();
        }else if($(this).val() == "INVESTIGADOR"){
            $("#div_depart_usuario").hide();
            $("#div_grupo_usuario").show();
            $("#div_centro_usuario").hide();
            $("#div_nombre_puesto").hide();
            $("#div_nivel_jerarquia").hide();
        }else if($(this).val() == "ADMINISTRACION"){
            $("#div_depart_usuario").hide();
            $("#div_grupo_usuario").hide();
            $("#div_centro_usuario").hide();
            $("#div_nombre_puesto").show();
            $("#div_nivel_jerarquia").show();
        }
    });

    $("#addUserForm").validate({
        rules: {
            nombre: {
                maxLength: 15,
                minLength: 1,
                required: true,
                lettersonly: true
            },
            apellidos: {
                maxLength: 25,
                minLength: 1,
                required: true,
                lettersonly: true
            },
            password: {
                nowhitespace: true,
                alphanumeric: true,
                maxLength: 64,
                minLength: 1,
                required: true
            },
            fecha_nacimiento: {
                nowhitespace: true,
                required: true
            },
            email_usuario: {
                nowhitespace: true,
                email: true,
                maxLength: 30,
                minLength: 1,
                required: true
            },
            telef_usuario: {
                nowhitespace: true,
                digit: true,
                maxLength: 9,
                minLength: 1,
                required: true
            },
            dni: {
                nowhitespace: true,
                maxLength: 9,
                minLength: 9,
                required: true,
                dniCheck: true
            },
            rol: {
                required: true
            },
            afiliacion: {
                required: true
            },
            nombre_puesto: {
                nowhitespace: true,
                maxLength: 60,
                minLength: 1,
            },
            nivel_jerarquia: {
                nowhitespace: true,
                digit: true
            },
            depart_usuario: {
                nowhitespace: true,
                digit: true
            },
            grupo_usuario: {
                nowhitespace: true,
                digit: true
            },
            centro_usuario: {
                nowhitespace: true,
                digit: true
            }
        },
        errorClass:  'fieldError',
        onkeyup:     false,
        onblur:      false,
        errorElement:'label',
        messages : {
            nombre: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 15 caracteres.",
                lettersonly: "El campo debe ser alfabético"
            },
            apellidos: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 25 caracteres.",
                lettersonly: "El campo debe ser alfabético"
            },
            password: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 64 caracteres.",
                alphanumeric: "El campo debe ser alfanumerico.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            fecha_nacimiento: {
                required: "El campo no puede estar vacío",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            email_usuario: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 30 caracteres.",
                email: "El campo debe ser un email.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            telef_usuario: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no puede estar vacío.",
                maxLength: "El campo no puede exceder los 9 caracteres.",
                digit: "El campo debe estar formado por números.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            dni: {
                required: "El campo no puede estar vacío",
                minLength: "El campo no debe tener 9 caracteres.",
                maxLength: "El campo no puede exceder los 9 caracteres.",
                dniCheck: "El campo debe ser un dni correcto.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            rol: {
                required: "El campo no puede estar vacío"
            },
            afiliacion: {
                required: "El campo no puede estar vacío"
            },
            nombre_puesto: {
                minLength: "El campo no debe estar vacío.",
                maxLength: "El campo no puede exceder los 60 caracteres.",
                nowhitespace: "El campo no puede ser un espacio en blanco"
            },
            nivel_jerarquia: {
                nowhitespace: "El campo no puede ser un espacio en blanco",
                digit: "El campo debe estar formado por números."
            },
            depart_usuario: {
                nowhitespace: "El campo no puede ser un espacio en blanco",
                digit: "El campo debe estar formado por números."
            },
            grupo_usuario: {
                nowhitespace: "El campo no puede ser un espacio en blanco",
                digit: "El campo debe estar formado por números."
            },
            centro_usuario: {
                nowhitespace: "El campo no puede ser un espacio en blanco",
                digit: "El campo debe estar formado por números."
            }
        },

    });

    $.validator.addMethod("dniCheck", function(value, element) {
        if(/^([0-9]{8})*[a-zA-Z]+$/.test(value)){
            var numero = value.substr(0,value.length-1);
            var let = value.substr(value.length-1,1).toUpperCase();
            numero = numero % 23;
            var letra='TRWAGMYFPDXBNJZSQVHLCKET';
            letra = letra.substring(numero,numero+1);
            if (letra==let) return true;
            return false;
        }
        return this.optional(element);
    }, "DNI no válido");
    $("#botonAddUser").click(function(){
        $("#addUserForm").submit();
        return false;
    });

    $("#botonAtras").click(function(){
        window.location.href = "../Controllers/User_Controller.php?action=showall";
        return false;
    });
});