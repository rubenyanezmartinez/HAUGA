<?php

class GRUPOINVESTIGACION_ADD_View{
    var $datos;
    var $esModificar;
    var $respuesta;

    function __construct($datos, $esModificar = false, $respuesta = false){
        $this->datos = $datos;
        $this->esModificar = $esModificar;
        $this->respuesta = $respuesta;

        $this->render();
    }

    function render(){
        include '../Views/Header.php'; //Incluye la cabecera
    ?>

<?php
    }
}
