<?php

class AdminIndex {

    //Constructor
    function __construct(){
        $this->render();
    }

    //Muestra la cabecera, la pagina de inicio y el pie;
    function render(){
        include '../Views/Header.php';

        include '../Views/Footer.php';
    }

}


?>
