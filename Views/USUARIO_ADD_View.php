<?php

//Clase que implementa la vista donde el administrador crea un usuario
class USUARIO_ADD_View{
var $datos;
var $grupos;
var $departamentos;
var $centros;
var $esModificar;
var $info_afiliacion;
var $respuesta;

//Constructor de la clase
function __construct($datos, $grupos, $departamentos, $centros, $esModificar = false, $info_afiliacion = "", $respuesta = false){
    $this->datos = $datos;
    $this->grupos = $grupos;
    $this->departamentos = $departamentos;
    $this->centros = $centros;
    $this->esModificar = $esModificar;
    $this->info_afiliacion = $info_afiliacion;
    $this->respuesta = $respuesta;
    $this->render();
}
//función que muestra la cabecera, inputs y el pie de la pagina de login
function render(){
    include '../Views/Header.php'; //Incluye la cabecera
?>
<!doctype html>
<html lang="es">

<div class="container">
    <div class="row">
       <!-- <div class="col-4"></div>-->
        <div class="col-12 align-self-center">
            <?php if($this->esModificar === false){?>
            <form action="../Controllers/User_Controller.php?action=add" method="post" id="addUserForm">
                <h2 class="text-center textoAzul mb-4">Crear Usuario</h2>
                <hr>
            <?php } else{?>
            <form action="../Controllers/User_Controller.php?action=edit&login_usuario=<?= $this->datos->getLogin()?>" method="post" id="editUserForm">
                <h2 class="text-center textoAzul mb-4">Editar Usuario</h2>
                <hr>
            <?php } ?>
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

                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?=$this->datos->getNombre()?>"
                            <?php if($this->esModificar === true){ ?> readonly <?php }?>size="15" maxlength="15">
                    </div>

                    <div class="col-md-6 form-group">
                        <select class=" form-control" id="rol" name="rol"
                            <?php if($this->esModificar === true && ( $_SESSION['rol'] != "ADMIN" && $_SESSION['rol'] != "Administrador")){ ?> readonly <?php }?>>
                            <?php
                                if($this->datos->getRol() == 'ADMIN' || $this->datos->getRol() == 'Administrador'){
                                    ?>
                                    <option value="" disabled>Rol</option>
                                    <option value="ADMIN" selected>Administrador</option>
                                    <option value="USUARIO_NORMAL">Usuario normal</option>
                                    <?php
                                }else if($this->datos->getRol() == 'USUARIO_NORMAL' || $this->datos->getRol() == 'Usuario Normal'){
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
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Apellidos" size="25" maxlength="25"
                               value="<?=$this->datos->getApellidos()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?>>
                    </div>

                    <div class=" col-md-6 form-group">
                        <select class=" form-control" id="afiliacion" name="afiliacion"
                            <?php if($this->esModificar === true && ( $_SESSION['rol'] != "ADMIN" && $_SESSION['rol'] != "Administrador")){ ?> readonly <?php }?>>
                            <?php
                            if($this->datos->getAfiliacion() == 'DOCENTE'){
                                ?>
                                <option value="" disabled>Afiliación</option>
                                <option value="DOCENTE" selected >Docente</option>
                                <option value="INVESTIGADOR">Investigador</option>
                                <option value="ADMINISTRACION">Administración</option>
                                <?php
                            }else if($this->datos->getAfiliacion() == 'INVESTIGADOR'){
                                ?>
                                <option value="" disabled>Afiliación</option>
                                <option value="DOCENTE" >Docente</option>
                                <option value="INVESTIGADOR" selected>Investigador</option>
                                <option value="ADMINISTRACION">Administración</option>
                                <?php
                            }else if($this->datos->getAfiliacion() == 'ADMINISTRACION'){
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
                        <input type="password" class="form-control" id="password"  name="password" placeholder="Contraseña" size="64" maxlength="64" value="<?php echo($this->datos->getPassword())?>">
                    </div>

                    <div class="col-md-6 form-group" id="div_depart_usuario">
                        <select class=" form-control" id="depart_usuario" name="depart_usuario">

                                <option value="" disabled>Departamento</option>

                            <?php
                            foreach ($this->departamentos as $departamento){
                                if($departamento->getDepartId() == $this->datos->getDepartUsuario()){?>
                                    <option value="<?=$departamento->getDepartId()?>" selected><?= $departamento->getNombreDepart() ?></option>
                                <?php }else{?>
                                    <option value="<?=$departamento->getDepartId()?>"><?= $departamento->getNombreDepart() ?></option>
                                <?php }}?>
                        </select>
                    </div>

                    <div class="col-md-6 form-group" id="div_grupo_usuario">
                        <select class=" form-control" id="grupo_usuario" name="grupo_usuario">
                            <option value="" disabled>Grupo</option>

                            <?php
                                foreach ($this->grupos as $grupo){
                                    if($grupo->getGrupoId() == $this->datos->getGrupoUsuario){?>
                                        <option value="<?=$grupo->getGrupoId()?>" selected><?= $grupo->getNombreGrupo() ?></option>
                                   <?php }else{?>
                            <option value="<?=$grupo->getGrupoId()?>" ><?= $grupo->getNombreGrupo() ?></option>
                               <?php }}?>
                        </select>
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_nombre_puesto" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="nombre_puesto" name="nombre_puesto" placeholder="Nombre Puesto"
                            <?php if($this->esModificar === true && ( $_SESSION['rol'] != "ADMIN" && $_SESSION['rol'] != "Administrador")){ ?> readonly <?php }?>
                               size="60" maxlength="60" value="<?=$this->datos->getNombrePuesto()?>">
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
                        <input type="date" class="form-control" onkeydown="return false"  id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha nacimiento"
                               value="<?= $this->datos->getFechaNacimiento()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?>>
                    </div>

                    <div class="col-md-6 form-group" id="div_centro_usuario">
                        <select class=" form-control" id="centro_usuario" name="centro_usuario">

                                <option value="" disabled>Centro</option>

                            <?php
                            foreach ($this->centros as $centro){
                                if($centro->getCentroId() == $this->datos->getCentroUsuario()){?>
                                    <option value="<?=$centro->getCentroId()?>" selected><?= $centro->getNombreCentro() ?></option>
                                <?php }else{?>
                                    <option value="<?=$centro->getCentroId()?>"><?= $centro->getNombreCentro() ?></option>
                                <?php }}?>

                        </select>
                    </div>

                    <div class="col-md-6 input-group mb-2" id="div_nivel_jerarquia" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend" >
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="number" class="form-control" id="nivel_jerarquia" name="nivel_jerarquia" placeholder="Nivel jerarquía"
                            <?php if($this->esModificar === true && ( $_SESSION['rol'] != "ADMIN" && $_SESSION['rol'] != "Administrador")){ ?> readonly <?php }?>
                               value="<?= $this->datos->getNivelJerarquia()?>">
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
                        <input type="email" class="form-control" id="email_usuario" name="email_usuario" placeholder="Email" size="30" maxlength="30" value="<?= $this->datos->getEmailUsuario()?>">

                    </div>

                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <?php if($this->esModificar === true){ ?>
                            <div class="input-group-prepend" >
                                <div class="input-group-text" style="background-color: #073349;">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="login" class="form-control" id="login_usuario" name="login_usuario" size="30" maxlength="12"
                                   value="<?= $this->datos->getLogin()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?>>
                        <?php } ?>
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
                        <input type="tel" class="form-control" id="telef_usuario" name="telef_usuario" placeholder="Teléfono" pattern="[0-9]{9}" value="<?= $this->datos->getTelefUsuario() ?>">
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
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI" size="9" maxlength="9"
                               value="<?= $this->datos->getDni()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?>>

                    </div>

                    <div class="col-md-6 input-group mb-2">

                    </div>


                </div>
                <?php if($this->datos->getNombre() != '' && $this->esModificar === false){ ?>
                    <div class="alert alert-danger"><?=$this->respuesta?></div>
                <?php } ?>

                <div class ="row">
                    <div class="col-md-3  mb-2 text-left" style="margin-bottom: 1rem!important;">
                        <?php if($this->esModificar === false){?>
                            <button id="botonAddUser" type='submit' name='action' value='addUser' class="btn" style="background-color: #073349; color: white;">
                                Crear usuario
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                        <?php } else{ ?>
                            <button id="botonEditUser" type='submit' name='action' value='editUser' class="btn btn-warning" style="background-color: #073349; color: white;">
                                Editar usuario
                                <svg style="background-color: #073349; color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                     class="bi bi-pencil" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                        <?php } ?>
                    </div>

                    <div class="col-md-3  mb-2 text-right" style="margin-bottom: 1rem!important;">

                        <button id="botonAtras" type='submit' name='action' value='atras' class="btn btn-light mr-4">
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
