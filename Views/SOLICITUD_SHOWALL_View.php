<?php

class SOLICITUD_SHOWALL_View{
    var $arraySolicitudes;
    var $arrayEspacios;
    var $arrayUsuarios;

    function __construct($arraySolicitudes, $arrayEspacios, $arrayUsuarios){
        $this->arraySolicitudes = $arraySolicitudes;
        $this->arrayEspacios = $arrayEspacios;
        $this->arrayUsuarios = $arrayUsuarios;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>
<div class="container">
    <div class="row align-self-center">
        <div class="col text-left">
            <?php
            include_once '../Functions/Authentication.php';
            include_once '../Functions/esAdministrador.php';
            ?>

        </div>
        <div class="col align-self-center">
            <h2 class="text-center textoAzul">Solicitudes</h2>
        </div>
        <div class="col text-right">

        </div>
    </div>
    <hr>
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr class="text-center" style="color: white;background-color: #073349;">
                <th scope="col">Espacio</th>
                <th scope="col">Usuario</th>
                <th scope="col">Correo Electrónico</th>
                <th style="width: 10%" scope="col">Opciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($this->arraySolicitudes as $solicitud){ ?>

                <tr>
                    <th scope="row"><?=$this->arrayEspacios[$solicitud->getSolicitudId()]->getNombreEsp()?></th>
                    <th><?=$this->arrayUsuarios[$solicitud->getSolicitudId()]->getNombre() . " " . $this->arrayUsuarios[$solicitud->getSolicitudId()]->getApellidos()?></th>
                    <th><?=$this->arrayUsuarios[$solicitud->getSolicitudId()]->getEmailUsuario()?></th>
                    <th style="text-align: center">
                        <a class="text-success text-decoration-none" href="../Controllers/Espacio_Controller.php?action=aceptarSolicitud&solicitud_id=<?=$solicitud->getSolicitudId()?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </a>
                        <a class="text-danger text-decoration-none" href="../Controllers/Espacio_Controller.php?action=denegarSolicitud&solicitud_id=<?=$solicitud->getSolicitudId()?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
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
}