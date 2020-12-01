<?php

//Clase que implementa la vista donde el administrador crea un usuario
class USUARIO_ADD_View{

//Constructor de la clase
function __construct(){
    $this->render();
}
//función que muestra la cabecera, inputs y el pie de la pagina de login
function render(){

?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portada</title>

    <!-- Estilos propios -->
    <link href="../libraries/estilos.css" rel="stylesheet">

    <!-- ENLACES A JQUERY -->
    <script src="../libraries/jquery/dist/jquery.slim.min.js"></script>
    <script src="../libraries/jquery/dist/jquery.min.js"></script>

    <!-- ENLACES A BOOTSTRAP -->
    <link href="../libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../libraries/bootstrap/dist/js/bootstrap.js"></script>

    <script>
        $(document).ready(function(){
            $("#div_grupo_usuario").hide();
            $("#div_nombre_puesto").hide();
            $("#div_nivel_jerarquia").hide();
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
    });
    </script>



    <nav id="barra-fija-superior" class="nav">
        <div class="container">
            <div class="row" style="padding-top: 1%">
                <div class="col-6">
                    <img class="logo-uvigo align-bottom" src="img/logo-barra-superior.svg" alt="Universidade de Vigo">
                </div>
                <div class="col-6 align-self-center text-right">
                    <h2 style="color: white;">GESTIÓN DE ESPACIOS</h2>
                </div>
            </div>
        </div>
    </nav>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 align-self-center">
            <form action="../Controllers/Usuario_Controller.php?action=ADD" method="post">
                <h2 class="text-center textoAzul">Crear Usuario</h2>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="password" class="form-control" id="password"  name="password" placeholder="Contraseña">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="date" class="form-control" onkeydown="return false"  id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha nacimiento">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="email" class="form-control" id="email_usuario" name="email_usuario" placeholder="Email">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="tel" class="form-control" id="telef_usuario" name="telef_usuario" placeholder="Teléfono" pattern="[0-9]{9}">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI">
                </div>

                <select class="mdb-select md-form colorful-select dropdown-primary" id="rol" name="rol">
                    <option value="ADMIN">Administrador</option>
                    <option value="USUARIO_NORMAL">Usuario normal</option>
                </select>
                <label class="mdb-main-label">Rol</label>

                <select class="mdb-select md-form colorful-select dropdown-primary" id="afiliacion" name="afiliacion" data-departamento="depart_usuario">
                    <option value="DOCENTE" selected>Docente</option>
                    <option value="INVESTIGADOR">Investigador</option>
                    <option value="ADMINISTRACION">Administración</option>
                </select>
                <label class="mdb-main-label">Rol</label>

                <div class="input-group mb-2" id="div_depart_usuario">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="number" class="form-control" id="depart_usuario" name="depart_usuario" placeholder="Departamento">
                </div>

                <div class="input-group mb-2" id="div_centro_usuario">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="number" class="form-control" id="centro_usuario" name="centro_usuario" placeholder="Centro">
                </div>

                <div class="input-group mb-2" id="div_grupo_usuario">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="number" class="form-control" id="grupo_usuario" name="grupo_usuario" placeholder="Grupo">
                </div>

                <div class="input-group mb-2" id="div_nombre_puesto">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="nombre_puesto" name="nombre_puesto" placeholder="Nombre Puesto">
                </div>

                <div class="input-group mb-2" id="div_nivel_jerarquia">
                    <div class="input-group-prepend">
                        <div class="input-group-text" style="background-color: #073349;">
                            <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </div>
                    </div>
                    <input type="number" class="form-control" id="nivel_jerarquia" name="nivel_jerarquia" placeholder="Nivel jerarquía">
                </div>





                <button type="submit" style="background-color: #073349;" class="btn btn-primary">Crear</button>

            </form>

        </div>
        <div class="col-4"></div>

    </div>

</div>



<?php
//include '../Views/Footer.php';
} //fin metodo render

} //fin Login

?>
