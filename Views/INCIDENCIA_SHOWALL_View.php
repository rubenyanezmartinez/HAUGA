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
                                <a href="../Controllers/Incidencia_Controller.php?action=aceptar&incidencia_id=<?=$incidencia->getIncidenciaId()?>">
                                    <svg style="color: green" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                </a>

                                <a href="../Controllers/Incidencia_Controller.php?action=denegar&incidencia_id=<?=$incidencia->getIncidenciaId()?>">
                                    <svg style="color: red" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                </a>
                                
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