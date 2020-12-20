<?php
class EDIFICIO_ADD_View{

var $datos;
var $agrupaciones;
var $esModificar;
var $respuesta;

//Constructor de la clase
function __construct($datos, $agrupaciones, $esModificar=false, $respuesta=''){
    $this->datos = $datos;
    $this->agrupaciones = $agrupaciones;
    $this->esModificar = $esModificar;
    $this->respuesta = $respuesta;
    $this ->render();
}

function render(){
include '../Views/Header.php'; //Incluye la cabecera
?>
    <!doctype html>
    <html lang="es">

    <div class="container">
        <div class="row">
            <div class="col-12 align-self-center">
                <?php if($this->esModificar === false){?>
                <form action="../Controllers/Edificio_Controller.php?action=add" method="post" id="addEdificioForm">
                    <h2 class="text-center textoAzul mb-4">Crear Edificio</h2>
                    <hr>
                    <?php } else{?>
                    <form action="../Controllers/Edificio_Controller.php?action=edit&edificio_id=<?= $this->datos->getEdificioId()?>" method="post" id="editEdificioForm">
                        <h2 class="text-center textoAzul mb-4">Editar Edificio</h2>
                        <hr>
                <?php } ?>
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
                            <input type="text" class="form-control" id="nombre_edif" name="nombre_edif" placeholder="Nombre Edificio"  size="70" maxlength="70" value="<?=$this->datos->getNombreEdificio()?>">
                        </div>

                        <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                            <div class="input-group-prepend">
                                <div class="input-group-text" style="background-color: #073349;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-layers-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.765 1.559a.5.5 0 0 1 .47 0l7.5 4a.5.5 0 0 1 0 .882l-7.5 4a.5.5 0 0 1-.47 0l-7.5-4a.5.5 0 0 1 0-.882l7.5-4z"/>
                                        <path fill-rule="evenodd" d="M2.125 8.567l-1.86.992a.5.5 0 0 0 0 .882l7.5 4a.5.5 0 0 0 .47 0l7.5-4a.5.5 0 0 0 0-.882l-1.86-.992-5.17 2.756a1.5 1.5 0 0 1-1.41 0l-5.17-2.756z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="number" class="form-control" id="num_plantas" name="num_plantas" placeholder="Número de plantas" value="<?=$this->datos->getNumPlantas()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?> >
                        </div>
                    </div>

                    <!-- Segunda fila -->
                    <div class="row">

                        <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                            <div class=" input-group-prepend">
                                <div class="input-group-text" style="background-color: #073349;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="direccion_edif" name="direccion_edif" placeholder="Direccion Edificio"  size="70" maxlength="70" value="<?=$this->datos->getDireccionEdif()?>" <?php if($this->esModificar === true){ ?> readonly <?php }?>>
                        </div>

                        <div class="col-md-6 form-group" id="div_agrup_edificio">
                            <select class=" form-control" id="agrup_edificio" name="agrup_edificio">

                                <option value="" disabled>Agrupacion</option>
                                <?php
                                foreach ($this->agrupaciones as $agrupacion){
                                    if($agrupacion->getAgrupId() == $this->datos->getAgrup_edificio()){?>

                                        <option value="<?= $agrupacion->getAgrupId()?>" selected><?php echo $agrupacion->getNombreAgrup() ?></option>
                                    <?php }else{?>
                                     <option value="<?= $agrupacion->getAgrupId()?>"><?php echo $agrupacion->getNombreAgrup() ?></option>
                                    <?php }}?>
                            </select>
                        </div>
                    </div>

                    <!-- Tercera fila -->
                    <div class="row">
                        <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                            <div class=" input-group-prepend">
                                <div class="input-group-text" style="background-color: #073349;">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-telephone-fill" fill="white" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M2.267.98a1.636 1.636 0 0 1 2.448.152l1.681 2.162c.309.396.418.913.296 1.4l-.513 2.053a.636.636 0 0 0 .167.604L8.65 9.654a.636.636 0 0 0 .604.167l2.052-.513a1.636 1.636 0 0 1 1.401.296l2.162 1.681c.777.604.849 1.753.153 2.448l-.97.97c-.693.693-1.73.998-2.697.658a17.47 17.47 0 0 1-6.571-4.144A17.47 17.47 0 0 1 .639 4.646c-.34-.967-.035-2.004.658-2.698l.97-.969z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="tel" class="form-control" id="telef_depart" name="telef_edif" placeholder="Teléfono Edificio" pattern="[0-9]{9}" value="<?=$this->datos->getTelefEdif()?>" >
                        </div>
                    </div>


                    <!-- Fila final de botones -->
                    <div class ="row">
                        <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;">
                            <button id="botonAtrasAddEdificio" type='submit' name='action' value='atras' class="btn btn-light mr-4">
                                Atrás
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </button>
                            <?php  if($this->esModificar === false){?>
                            <button id="botonAddEdificio" type='submit' name='action' value='addEdificio' class="btn btn-success">
                                Crear Edificio
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                            <?php } else{ ?>
                            <button id="botonEditEdificio" type='submit' name='action' value='editEdificio' class="btn btn-success">
                                Editar Edificio
                                <svg  width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                     class="bi bi-pencil" fill="white" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </button>
                            <?php } ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    }
}
?>