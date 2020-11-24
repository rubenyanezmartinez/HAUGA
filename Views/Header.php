<?php

include_once'../Functions/Authentication.php';

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

    <!-- ENLACES A BOOTSTRAP -->
    <link href="../libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../libraries/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../libraries/bootstrap/dist/js/bootstrap.js"></script>


    <nav id="barra-fija-superior" class="nav">
        <div class="container">
            <div class="row" style="padding-top: 1%">
                <div class="col-auto">
                    <img class="logo-uvigo align-bottom" src="img/logo-barra-superior.svg" alt="Universidade de Vigo">
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
                        <a class="textoBlanco align-bottom" href="../Functions/Desconectar.php"> CERRAR SESIÓN </a>

                    <?php } else {?>

                        <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg>
                        <a class="textoBlanco align-bottom" href="#"> INICIAR SESIÓN</a>

                    <?php } ?>


                </div>
            </div>
        </div>
    </nav>

</head>

<body>

    <nav class="nav">
        <div class="container">
            <div class="row" style="padding-top: 1%">

                <div class="col-2 align-self-center text-center">
                    <h4><a href="#" class="textoAzul">CENTROS</a></h4>
                </div>

                <div class="col-2 align-self-center text-center">
                    <h4><a href="#" class="textoAzul">EDIFICIOS</a></h4>
                </div>

                <div class="col-2 align-self-center text-center">
                    <h4><a href="#" class="textoAzul">ESPACIOS</a></h4>
                </div>

                <div class="col-3 align-self-center text-center">
                    <h4><a href="#" class="textoAzul">DEPARTAMENTOS</a></h4>
                </div>

                <div class="col-3 align-self-center text-center">
                    <h4><a href="#" class="textoAzul">GRUPOS DE INVESTIGACIÓN</a></h4>
                </div>

            </div>
        </div>
    </nav>
