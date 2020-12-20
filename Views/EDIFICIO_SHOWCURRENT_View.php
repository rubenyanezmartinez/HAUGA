<?php
class EDIFICIO_SHOWCURRENT_View{
    var $edificio;
    var $agrupacion;

    function __construct($edificio, $agrupacion)
    {
        $this->edificio = $edificio;
        $this->agrupacion = $agrupacion;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>

        <div class="container">

            <?php if ($this->edificio == null){ ?>
                <div class="alert alert-danger">El edificio al que está intentando acceder no existe.</div>
            <?php } else { ?>

                <div class="row">
                    <div class="col text-center">
                        <h2 class="textoAzul">Vista en detalle del edificio <?=$this->edificio->getNombreEdif() ?></h2>
                    </div>
                </div>

                <hr>

                <ul>
                    <div class="row">
                        <div class="col text-left">
                            <li><b>Nombre: </b><?=$this->edificio->getNombreEdif()?></li>
                        </div>
                    </div>


                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Dirección: </b><?=$this->edificio->getDireccionEdif()?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Teléfono: </b><?=$this->edificio->getTelefEdif()?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Número de plantas: </b><?=$this->edificio->getNumPlantas()?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Agrupación: </b><?=$this->agrupacion['nombre_agrup'] ?></li>
                        </div>
                    </div>

                </ul>
            <div class="row">
                <div class="col text-right">
                    <a id="botonAtrasCurrentUser" href="../Controllers/Edificio_Controller.php?action=showall&agrupacion_id=<?=$this->agrupacion['agrup_id']?>" class="btn btn-light">
                        Atrás
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>
            </div>

            </div>
        <?php } ?>
<?php
    }
}