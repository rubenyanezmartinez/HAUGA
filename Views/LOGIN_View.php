<?php

//Clase que implementa la vista donde el usuario introduce el login y la contraseñapara acceder a la aplicación
class LOGIN_View{

//Constructor de la clase
    function __construct(){
        $this->render();
    }
//función que muestra la cabecera, inputs y el pie de la pagina de login
    function render(){

        ?>
        



        <?php
        include '../Views/Footer.php';
    } //fin metodo render

} //fin Login

?>
