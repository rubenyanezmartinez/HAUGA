<?php

include_once '../Functions/Authentication.php';
include_once '../Functions/esAdministrador.php';

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Portada</title>

    <!-- Estilos propios -->
    <link href="../libraries/estilos.css" rel="stylesheet">

    <!-- ENLACES A JQUERY -->
    <script src="../libraries/jquery/dist/jquery.slim.min.js"></script>
    <script src="../libraries/jquery/dist/jquery.min.js"></script>
    <script src="../libraries/jquery/jquery.validate.min.js"></script>

    <!-- ENLACES A BOOTSTRAP -->
    <link href="../libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../libraries/bootstrap/dist/js/bootstrap.js"></script>

    <script src="../libraries/jquery/jquery.validate.js"></script>
    <script src="../libraries/jquery/jquery.validate.min.js"></script>
    <script src="../libraries/jquery/additional-methods.js"></script>
    <script src="../libraries/jquery/additional-methods.min.js"></script>
    <script type="text/javascript" src="../Views/js/validacionesAddUser.js"></script>
    <script type="text/javascript" src="../Views/js/validacionesAddDepartamento.js"></script>
    <script type="text/javascript" src="../Views/js/validacionesAddAgrupacion.js"></script>
    <script type="text/javascript" src="../Views/js/validacionesAddGrupoInvestigacion.js"></script>


    <nav id="barra-fija-superior" class="nav">
        <div class="container">
            <div class="row" style="padding-top: 1%">
                <div class="col-auto">
                    <a href="../Controllers/Index_Controller.php">
                        <img class="logo-uvigo align-bottom" src="../Views/img/logo-barra-superior.svg" alt="Universidade de Vigo">
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    <a class="textoBlanco" href="http://campusdaauga.uvigo.es/">CAMPUS DA AUGA</a>
                    <a class="textoBlanco" href="http://www.perseo.biblioteca.uvigo.es/search*spi">BIBLIOTECA</a>
                    <a class="textoBlanco" href="https://www.uvigo.gal/campus/deporte">DEPORTES</a>
                    <a class="textoBlanco" href="https://correoweb.uvigo.gal/login.php">CORREO UVIGO</a>
                    <a class="textoBlanco" href="https://moovi.uvigo.gal/">MOOVI</a>
                    <a class="textoBlanco" href="https://www.uvigo.gal/universidade/comunicacion/duvi">DUVI</a>
                </div>
                <div class="col-auto text-right">
                    <?php if (IsAuthenticated()) {?>

                        <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-x-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                        </svg>
                        <a class="textoBlanco align-bottom" href="../Controllers/User_Controller.php?action=logout"> CERRAR SESIÓN </a>

                    <?php } else {?>

                        <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <a class="textoBlanco align-bottom" href='../Controllers/User_Controller.php'> INICIAR SESIÓN</a>

                    <?php } ?>


                </div>
            </div>
        </div>
    </nav>

</head>

<body>

    <nav class="nav">
        <div class="container col-12">
            <div class="row col-12" style="padding-top: 1%">

                <?php if (esAdministrador() == "admin") {?>
                    <div class="col-2 align-self-center text-center">
                        <h5><a href="#" class="textoAzul">CENTROS</a></h5>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h5><a href="../Controllers/AGRUPACION_Controller.php?action=showall&num_pag=1" class="textoAzul">EDIFICIOS</a></h5>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h5><a href="../Controllers/Espacio_Controller.php?action=showall" class="textoAzul">ESPACIOS</a></h5>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h5><a href="../Controllers/Departamento_Controller.php?action=showall" class="textoAzul">DEPARTAMENTOS</a></h5>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h5><a href="../Controllers/GrupoInvestigacion_Controller.php?action=showall" class="textoAzul">GRUPOS INVG.</a></h5>
                    </div>
                    <div class="col-2 align-self-center text-center">
                        <h5><a href="../Controllers/User_Controller.php?action=showall&numero_pagina=1" class="textoAzul">USUARIOS</a></h5>
                    </div>
                <?php } else { ?>
                    <div class="col-2 align-self-center text-center">
                        <h4><a href="#" class="textoAzul">CENTROS</a></h4>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h4><a href="../Controllers/AGRUPACION_Controller.php?action=showall&num_pag=1" class="textoAzul">EDIFICIOS</a></h4>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h4><a href="../Controllers/Espacio_Controller.php?action=showall" class="textoAzul">ESPACIOS</a></h4>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h4><a href="../Controllers/Departamento_Controller.php?action=showall" class="textoAzul">DEPARTAMENTOS</a></h4>
                    </div>

                    <div class="col-2 align-self-center text-center">
                        <h4><a href="../Controllers/GrupoInvestigacion_Controller.php?action=showall" class="textoAzul">GRUPOS INVG.</a></h4>
                    </div>
                    <?php if(IsAuthenticated()){ ?>
                        <div class="col-2 align-self-center text-center">
                            <h4><a href="../Controllers/User_Controller.php?action=showcurrent&login_usuario=<?= $_SESSION['login']?>"
                                   class="textoAzul">MIS DATOS</a></h4>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>
        </div>
    </nav>

    <hr>
