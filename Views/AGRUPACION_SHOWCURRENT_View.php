<?php
class AGRUPACION_SHOWCURRENT_View{
    var $agrupacion;
    var $esNuevo;
    var $respuesta;

    function __construct($agrupacion = null, $esNuevo = false, $respuesta = '')
    {
        $this->agrupacion = $agrupacion;
        $this->esNuevo = $esNuevo;
        $this->respuesta = $respuesta;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>
        <div class="container">
            <?php if($this->agrupacion == null && !$this->esNuevo) { ?>
                <div class="alert alert-danger">La agrupación a la que está intentando acceder no existe.</div>
            <?php } else { ?>
                <?php if($this->respuesta !=''){ ?>
                    <div class="alert alert-danger"><?php echo($this->respuesta)?></div>
                <?php } ?>
                <div class="row">
                    <div class="col-12 align-self-center">
                        <form action="../Controllers/AGRUPACION_Controller.php?action=add" method="post" id="addAgrupForm">
                            <h2 class="text-center textoAzul mb-4"><?php echo $this->esNuevo ? 'Crear' : 'Detalles'?> Agrupación</h2>
                            <hr>
                            <div class="row align-content-center">
                                <div class="col-md-12 input-group mb-2" style="margin-bottom: 1rem!important;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="background-color: #073349; color: white;">
                                            Nombre
                                        </div>
                                    </div>
                                    <input <?php echo !$this->esNuevo ? 'disabled' : ''; ?> required type="text" class="form-control" id="nombre_agrup" name="nombre_agrup" placeholder="Nombre" value="<?php echo($this->agrupacion['nombre_agrup'])?>" size="50" maxlength="50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 input-group mb-2" style="margin-bottom: 1rem!important;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="background-color: #073349; color: white;">
                                            Ubicación
                                        </div>
                                    </div>
                                    <input <?php echo !$this->esNuevo ? 'disabled' : ''; ?> required type="text" class="form-control" id="ubicacion_agrup" name="ubicacion_agrup" placeholder="Ubicación" value="<?php echo($this->agrupacion['ubicacion_agrup'])?>" size="100" maxlength="100">
                                </div>
                            </div>
                            <div class="row">
                                <?php if($this->esNuevo) {?>
                                    <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                        <button id="botonAddAgrupacion" type='submit' name='action' value='addAgrupacion' class="btn btn-success" style="background-color: #073349; color: white;">
                                            Crear Agrupacion
                                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </button>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-6 mb-2 text-left" style="margin-bottom: 1rem!important;">
                                        <a id="botonVerEdificios" href="#" class="btn btn-light">
                                            Ver edificios
                                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                                <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                            </svg>
                                        </a>
                                    </div>
                                <?php } ?>


                                <div class="col-md-6  mb-2 text-right" style="margin-bottom: 1rem!important;">
                                    <a id="botonAtrasAgrup" href="../Controllers/AGRUPACION_Controller.php?action=showall" class="btn btn-light">
                                        Atrás
                                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>

            </div>
    <?php
    }
}