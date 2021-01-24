<?php

class INCIDENCIA_SHOWALL_View{

    var $incidencias;
    var $espacios;

    function __construct($incidencias, $espacios){
        $this->incidencias = $incidencias;
        $this->espacios = $espacios;
        $this->showall();
    }

    function showall(){
        include '../Views/Header.php';

        ?>
        <div class="container">
            <div class="row align-self-center">
                <div class="col align-self-center">
                    <h2 class="text-center textoAzul">Incidencias</h2>
                </div>
                <div class="col text-right">

                </div>
            </div>
            <?php 
                if(sizeof($this->incidencias) == 0){
                    echo "No existen incidencias";
                }
                else{
            ?>
            <hr>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Espacio</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                        <th style="width: 10%" scope="col">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->incidencias as $incidencia){?>

                        <tr>
                            <th scope="row"><?=$this->espacios[$incidencia->getEspacioAfectado()]?></th>
                            <th><?=$incidencia->getDescripcionIncid()?></th>
                            <th><?=$incidencia->getEstadoIncid()?></th>
                            <th style="text-align: center">
                        <?php
                        if($incidencia->getEstadoIncid() == "PEND"){?>

                                <a href="../Controllers/Incidencia_Controller.php?action=aceptar&incidencia_id=<?=$incidencia->getIncidenciaId()?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </a>

                                <a href="../Controllers/Incidencia_Controller.php?action=denegar&incidencia_id=<?=$incidencia->getIncidenciaId()?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>
                                

                            <?php } ?>
                            </th>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>
        </div>
        <?php
        include '../Views/Footer.php';
    }
}

?>