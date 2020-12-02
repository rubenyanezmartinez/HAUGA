<?php

//Clase que implementa la vista donde el administrador crea un usuario
class USUARIO_ADD_View{
var $datos;
//Constructor de la clase
function __construct($datos = ["nombre" => '', "apellidos" => '', "password" => '', "fecha_nacimiento" => '',
    "email_usuario" => '', "telef_usuario" => '', "dni" => '', "rol" => '', "afiliacion" => '',
    "nombre_puesto" => '', "nivel_jerarquia" => '', "depart_usuario" => '', "grupo_usuario" => '', "centro_usuario" => '',"respuesta"=>'']){
    $this->datos = $datos;
    $this->render();
}
//función que muestra la cabecera, inputs y el pie de la pagina de login
function render(){
    include '../Views/Header.php'; //Incluye la cabecera
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
    <script src="../libraries/jquery/jquery.validate.js"></script>
    <script src="../libraries/jquery/jquery.validate.min.js"></script>
    <script src="../libraries/jquery/additional-methods.js"></script>
    <script src="../libraries/jquery/additional-methods.min.js"></script>
   <script type="text/javascript" src="../Views/js/validacionesAddUser.js"></script>

</head>

<body>

<div class="container">
    <div class="row">
       <!-- <div class="col-4"></div>-->
        <div class="col-12 align-self-center">
            <form action="../Controllers/User_Controller.php?action=add" method="post" id="addUserForm">
                <h2 class="text-center textoAzul mb-4">Crear Usuario</h2>

                <!-- Primera fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class=" input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo($this->datos['nombre'])?>" size="15" maxlength="15">
                    </div>

                    <div class="col-md-6 form-group">
                        <select class=" form-control" id="rol" name="rol">
                            <?php
                                if($this->datos['rol'] == 'ADMIN'){
                                    ?>
                                    <option value="" disabled>Rol</option>
                                    <option value="ADMIN" selected>Administrador</option>
                                    <option value="USUARIO_NORMAL">Usuario normal</option>
                                    <?php
                                }else if($this->datos['rol'] == 'USUARIO_NORMAL'){
                            ?>
                            <option value="" disabled>Rol</option>
                            <option value="ADMIN">Administrador</option>
                            <option value="USUARIO_NORMAL" selected>Usuario normal</option>
                                    <?php
                                }else{
                            ?>
                            <option value="" disabled selected>Rol</option>
                            <option value="ADMIN">Administrador</option>
                            <option value="USUARIO_NORMAL">Usuario normal</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>


                </div>

                <!-- Segunda fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-file-person-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" size="25" maxlength="25" value="<?php echo($this->datos['apellidos'])?>">
                    </div>

                    <div class=" col-md-6 form-group">
                        <select class=" form-control" id="afiliacion" name="afiliacion">
                            <?php
                            if($this->datos['afiliacion'] == 'DOCENTE'){
                                ?>
                                <option value="" disabled>Afiliación</option>
                                <option value="DOCENTE" selected >Docente</option>
                                <option value="INVESTIGADOR">Investigador</option>
                                <option value="ADMINISTRACION">Administración</option>
                                <?php
                            }else if($this->datos['afiliacion'] == 'INVESTIGADOR'){
                                ?>
                                <option value="" disabled>Afiliación</option>
                                <option value="DOCENTE" >Docente</option>
                                <option value="INVESTIGADOR" selected>Investigador</option>
                                <option value="ADMINISTRACION">Administración</option>
                                <?php
                            }else if($this->datos['afiliacion'] == 'ADMINISTRACION'){
                                ?>
                                <option value="" >Afiliación</option>
                                <option value="DOCENTE" >Docente</option>
                                <option value="INVESTIGADOR">Investigador</option>
                                <option value="ADMINISTRACION" selected>Administración</option>
                                <?php
                            }else{
                            ?>
                            <option value="" disabled selected>Afiliación</option>
                            <option value="DOCENTE" >Docente</option>
                            <option value="INVESTIGADOR">Investigador</option>
                            <option value="ADMINISTRACION">Administración</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Tercera fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="password" class="form-control" id="password"  name="password" placeholder="Contraseña" size="64" maxlength="64" value="<?php echo($this->datos['password'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_depart_usuario">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="number" class="form-control" id="depart_usuario" name="depart_usuario" placeholder="Departamento" value="<?php echo($this->datos['depart_usuario'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_grupo_usuario">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="number" class="form-control" id="grupo_usuario" name="grupo_usuario" placeholder="Grupo" value="<?php echo($this->datos['grupo_usuario'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_nombre_puesto">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="nombre_puesto" name="nombre_puesto" placeholder="Nombre Puesto" size="60" maxlength="60" value="<?php echo($this->datos['nombre_puesto'])?>">
                    </div>
                </div>

                <!-- Cuarta fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-calendar-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V5h16V4H0V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="date" class="form-control" onkeydown="return false"  id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha nacimiento" value="<?php echo($this->datos['fecha_nacimiento'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_centro_usuario">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="number" class="form-control" id="centro_usuario" name="centro_usuario" placeholder="Centro" value="<?php echo($this->datos['centro_usuario'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_nivel_jerarquia">
                        <div class="input-group-prepend" >
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="number" class="form-control" id="nivel_jerarquia" name="nivel_jerarquia" placeholder="Nivel jerarquía" value="<?php echo($this->datos['nivel_jerarquia'])?>">
                    </div>
                </div>

                <!-- Quinta fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-envelope-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="email" class="form-control" id="email_usuario" name="email_usuario" placeholder="Email" size="30" maxlength="30" value="<?php echo($this->datos['email_usuario'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2">

                    </div>


                </div>

                <!-- Sexta fila -->
                <div class="row">

                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-telephone-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="tel" class="form-control" id="telef_usuario" name="telef_usuario" placeholder="Teléfono" pattern="[0-9]{9}" value="<?php echo($this->datos['telef_usuario'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2">

                    </div>



                </div>

                <!-- Septima fila -->
                <div class="row">

                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-credit-card-2-front-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2.5 1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-2zm0 3a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1zm3 0a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" size="9" maxlength="9" value="<?php echo($this->datos['dni'])?>">

                    </div>

                    <div class="col-md-6 input-group mb-2">

                    </div>


                </div>
                <?php if($this->datos['nombre']!=''){ ?>
                    <div class="alert alert-danger"><?php echo($this->datos['respuesta'])?></div>
                <?php } ?>

                <div class ="row">
                        <div class="col-md-6 input-group mb-2">
                            <button id="botonAddUser" type='submit' name='action' value='addUser' class="btn btn-success">
                                Crear usuario
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        </div>

                        <div class="col-md-6 input-group mb-2">
                            <button id="botonAtras" type='submit' name='action' value='atras' class="btn btn-light">
                                Atrás
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </button>
                        </div>



                </div>

            </form>

        </div>
      <!--  <div class="col-4"></div>-->

    </div>

</div>


<?php
        //Incluye el pie de página.
        include '../Views/Footer.php';
} //fin metodo render

} //fin Login

?>
