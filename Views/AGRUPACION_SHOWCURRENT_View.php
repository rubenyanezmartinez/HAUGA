<?php
class AGRUPACION_SHOWCURRENT_View{
    var $agrupacion;
    var $esModificar;
    var $esNuevo;
    var $respuesta;

    function __construct($agrupacion = null, $esModificar = false, $esNuevo = false, $respuesta = '')
    {
        $this->agrupacion = $agrupacion;
        $this->esModificar = $esModificar;
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
                        <form action="../Controllers/AGRUPACION_Controller.php?action=<?php echo $this->esModificar ? 'edit' : 'add';?>" method="post" id="addAgrupForm">
                            <h2 class="text-center textoAzul mb-4"><?php echo $this->esNuevo ? 'Crear' : $this->esModificar ? 'Modificar' : 'Detalles'?> Agrupación</h2>

                            <div class="row align-content-center">
                                <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="background-color: #073349; color: white;">
                                            Nombre
                                        </div>
                                    </div>
                                    <input <?php echo !$this->esModificar && !$this->esNuevo ? 'disabled' : ''; ?> type="text" class="form-control" id="nombre_agrup" name="nombre_agrup" placeholder="Nombre" value="<?php echo($this->agrupacion['nombre_agrup'])?>" size="15" maxlength="15">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" style="background-color: #073349; color: white;">
                                            Ubicación
                                        </div>
                                    </div>
                                    <input <?php echo !$this->esModificar && !$this->esNuevo ? 'disabled' : ''; ?> type="text" class="form-control" id="ubicacion_agrup" name="ubicacion_agrup" placeholder="Ubicación" value="<?php echo($this->agrupacion['ubicacion_agrup'])?>" size="15" maxlength="15">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 input-group mb-2">
                                    <button <?php echo !$this->esModificar && !$this->esNuevo ? 'hidden' : ''; ?> id="botonAddAgrupacion" type='submit' name='action' value='addAgrupacion' class="btn btn-success">
                                        <?php echo $this->esNuevo ? 'Crear' :'Modificar'; ?> Agrupacion
                                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                    </button>
                                </div>


                                <div class="col-md-6 input-group mb-2">
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