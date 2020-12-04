<?php

//Clase que implementa la vista donde el administrador crea un DEPARTAMENTO
class DEPARTAMENTO_ADD_View{
var $datos;
var $edificios;
var $usuarios;
//Constructor de la clase
function __construct($datos, $edificios, $usuarios){
    $this->datos = $datos;
    $this->edificios = $edificios;
    $this->usuarios = $usuarios;
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
            <form action="../Controllers/Departamento_Controller.php?action=add" method="post" id="addDepartamentoForm">
                <h2 class="text-center textoAzul mb-4">Crear Departamento</h2>

                <!-- Primera fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class=" input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-fonts" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.258 3H3.747l-.082 2.46h.479c.26-1.544.758-1.783 2.693-1.845l.424-.013v7.827c0 .663-.144.82-1.3.923v.52h4.082v-.52c-1.162-.103-1.306-.26-1.306-.923V3.602l.43.013c1.935.062 2.434.301 2.694 1.846h.479L12.258 3z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="nombre_depart" name="nombre_depart" placeholder="Nombre Departamento" value="<?php echo($this->datos['nombre_depart'])?>" size="70" maxlength="70">
                    </div>

                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eyeglasses" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="area_conc_depart" name="area_conc_depart" placeholder="Área de Conocimiento" size="30" maxlength="30" value="<?php echo($this->datos['area_conc_depart'])?>">
                    </div>

                </div>

                <!-- Segunda fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-upc" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 4.5a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7zm2 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-7zm3 0a.5.5 0 0 1 1 0v7a.5.5 0 0 1-1 0v-7z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="text" class="form-control" id="codigo_depart" name="codigo_depart" placeholder="Código Departamento" size="9" maxlength="9" value="<?php echo($this->datos['codigo_depart'])?>">
                    </div>

                    <div class="col-md-6 form-group" id="div_edificio_depart">
                        <select class=" form-control" id="edificio_depart" name="edificio_depart">

                            <option value="" disabled>Edificio</option>

                            <?php
                            foreach ($this->edificios as $edificio){
                                if($edificio->edificio_id == $this->datos['edificio_depart']){?>
                                    <option value="<?=$edificio->edificio_id?>" selected><?php echo $edificio->nombre_edif ?></option>
                                <?php }else{?>
                                    <option value="<?=$edificio->edificio_id?>"><?php echo $edificio->nombre_edif ?></option>
                                <?php }}?>
                        </select>
                    </div>
                </div>

                <!-- Tercera fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-telephone-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="tel" class="form-control" id="telef_depart" name="telef_depart" placeholder="Teléfono Departamento" pattern="[0-9]{9}" value="<?php echo($this->datos['telef_depart'])?>">
                    </div>

                    <div class="col-md-6 form-group" id="div_responsable_depart">
                        <select class=" form-control" id="responsable_depart" name="responsable_depart">

                            <option value="" disabled>Responsable Departamento</option>

                            <?php
                            foreach ($this->usuarios as $usuario){
                                if($usuario->usuario_id == $this->datos['responsable_depart']){?>
                                    <option value="<?=$usuario->usuario_id?>" selected><?php echo $usuario->nombre ." ". $usuario->apellidos?></option>
                                <?php }else{?>
                                    <option value="<?=$usuario->usuario_id?>"><?php echo $usuario->nombre ." ". $usuario->apellidos ?></option>
                                <?php }}?>
                        </select>
                    </div>
                </div>

                <!-- Cuarta fila -->
                <div class="row">
                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                        <div class="input-group-prepend">
                            <div class="input-group-text" style="background-color: #073349;">
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-envelope-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                            </div>
                        </div>
                        <input type="email" class="form-control" id="email_depart" name="email_depart" placeholder="Email Departamento" size="30" maxlength="30" value="<?php echo($this->datos['email_depart'])?>">
                    </div>

                    <div class="col-md-6 input-group mb-2">

                    </div>


                </div>

                <?php if($this->datos['nombre_depart']!=''){ ?>
                    <div class="alert alert-danger"><?php echo($this->datos['respuesta'])?></div>
                <?php } ?>

                <div class ="row">
                    <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;">
                        <button id="botonAtrasAddDepartamento" type='submit' name='action' value='atras' class="btn btn-light mr-4">
                            Atrás
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                            </svg>
                        </button>

                        <button id="botonAddDepartamento" type='submit' name='action' value='addDepartamento' class="btn btn-success">
                            Crear departamento
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
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
