<?php


class ESPACIO_HISTORIAL_View
{
    var $espacio_id;
    var $nombre_espacio;
    var $responsables;
    var $num_pag;
    var $nombresResponsables;
    var $tarifasEspacios;

    function __construct($espacio_id, $nombre_espacio, $responsables, $num_pag, $nombresResponsables, $tarifasEspacios)
    {
        $this->espacio_id = $espacio_id;
        $this->nombre_espacio = $nombre_espacio;
        $this->responsables = $responsables;
        $this->num_pag = $num_pag;
        $this->nombresResponsables = $nombresResponsables;
        $this->tarifasEspacios = $tarifasEspacios;
        $this->render();
    }


    function render(){
        include '../Views/Header.php';

        ?>

        <div class="container">

            <div class="row align-self-center">
                <div class="col align-self-center">
                    <h2 class="text-center textoAzul"><?=$this->nombre_espacio . ': Historial de responsables'?></h2>
                </div>
            </div>

            <hr>


            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Responsable</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Tarifa</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->responsables as $responsable){ ?>

                        <tr>
                            <th scope="row"><?=$this->nombresResponsables[$responsable->getUsuarioId()]?></th>
                            <th><?=$responsable->getFecha()?></th>
                            <th><?=$this->tarifasEspacios[$responsable->getEspacioId()]?>€</th>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>


            <div class="row">
                <div class="col">
                    <nav aria-label="paginacion">
                        <ul class="pagination justify-content-end">
                            <?php for ($i = 1; $i < $this->num_pag + 1; $i++){
                                echo '<li class="page-item"><a class="page-link" style="background-color: #073349; color: white" href="../Controllers/Espacio_Controller.php?action=verHistorial&espacio_id='.$this->espacio_id.'&nombre_espacio='.$this->nombre_espacio.'&num_pag='.$i.'">'.$i.'</a></li>';
                            } ?>

                        </ul>
                    </nav>
                </div>
            </div>

            <div class="row">

                <div class="col text-right" style="margin-bottom: 1rem!important;">
                    <a id="botonAtrasCurrentUser" href="../Controllers/Espacio_Controller.php?action=showcurrent&espacio_id=<?=$this->espacio_id?>" class="btn btn-light">
                        Atrás
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>

        <?php
        include '../Views/Footer.php';
    }
}

?>