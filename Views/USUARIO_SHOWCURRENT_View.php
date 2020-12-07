<?php
class USUARIO_SHOWCURRENT_View{
    var $usuario;
    var $info_afiliacion;
    var $esModificar;

    function __construct($usuario = null, $info_afiliacion = '', $esModificar = false){
        $this->usuario = $usuario;
        $this->info_afiliacion = $info_afiliacion;
        $this->esModificar = $esModificar;
        $this->render();
    }


    function render(){

    include '../Views/Header.php'; //Incluye la cabecera

    ?>


        <div class="container">

            <?php if ($this->usuario == null){ ?>
                <div class="alert alert-danger">El usuario al que está intentando acceder no existe.</div>
            <?php } else if ($this->esModificar == false){ ?>

                <div class="row">
                    <div class="col text-center">
                        <h2 class="textoAzul">Vista en detalle de <?=$this->usuario->getLogin() ?></h2>
                    </div>
                </div>

                <hr>

                <ul>
                    <div class="row">
                        <div class="col text-left">
                            <li><b>Nombre: </b><?=$this->usuario->getNombre() ?></li>
                        </div>
                    </div>


                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Apellidos: </b><?=$this->usuario->getApellidos() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Fecha de nacimiento: </b><?=$this->usuario->getFechaNacimiento() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Correo electrónico: </b><?=$this->usuario->getEmailUsuario() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Teléfono: </b><?=$this->usuario->getTelefUsuario() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>DNI: </b><?=$this->usuario->getDni() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Rol: </b><?=$this->usuario->getRol() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Afiliación: </b><?=$this->usuario->getAfiliacion() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Información sobre afiliación: </b><?=$this->info_afiliacion ?></li>
                        </div>
                    </div>

                </ul>

            <?php } else { ?>

            <?php } ?>

            <div class="row">
                <div class="col text-left">
                    <a href="../Controllers/User_Controller.php?action=edit&login_usuario=<?=$this->usuario->getLogin()?>" class="btn">
                        <button class="btn" style="background-color: #073349; color: white">
                            Modificar usuario
                            <svg style="background-color: #073349; color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                 class="bi bi-pencil" fill="white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                        </button>
                    </a>
                </div>
                <div class="col text-right">
                    <?php

                    if ($_SESSION['rol'] == 'ADMIN'){
                        $ruta = "../Controllers/User_Controller.php?action=showall&numero_pagina=1";
                    }else{
                        $ruta = "../Controllers/Index_Controller.php";
                    }

                    ?>
                    <a id="botonAtrasCurrentUser" href="<?= $ruta ?>" class="btn btn-light">
                        Atrás
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>


        <?php
        //Incluye el pie de página.
        include '../Views/Footer.php';
    }

}


?>