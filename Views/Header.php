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

    <!-- ENLACES A BOOTSTRAP -->
    <link href="../libraries/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../libraries/bootstrap/js/bootstrap.min.js"></script>
    <!-- ENLACES A JQUERY -->
    <script src="../libraries/jquery/dist/jquery.slim.min.js"></script>


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
                    <svg style="color: white" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </svg>
                    <a class="textoBlanco align-bottom" href="#"> INICIAR SESIÓN</a>
                </div>
            </div>
        </div>
    </nav>

</head>

<body>
