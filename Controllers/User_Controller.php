<?php
include '../Views/LOGIN_View.php';
include '../Functions/Authentication.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
session_start();
echo('User_controller');

if(!IsAuthenticated()){
    login();
}else{
    if(!isset($_GET['action'])){
        $action = '';
    } else{
        $action = $_GET['action'];
    }

    switch($action){

        default: echo('default del switch user_controller');
            break;
    }
}

function login(){
    echo('User_controller/login');

    if(!isset($_POST['login']) && !isset($_POST['password'])){    //Si no estan instanciadas login y password
        echo('\n sin datos login');
        $login = new Login_view();  //Muestra vista de login
    } else{ //Si se recibieron el login y la password
        echo(' con datos login');
        $usuario = new USUARIO_Model(null, $_POST['login'], "", "",$_POST['password'], ""
            ,"","","","","","",
            "","","","");

        $respuesta = $usuario->login();

        if($respuesta){ //Si coincide la contraseña dada con la del usuario
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['rol'] = $usuario->getRol();

            header('Location:../index.php');
        }else{
            echo('error no coincide la contraseña user_controller/login');
            //MOSTRAR MENSAJE DE ERROR ENVIADO POR EL MODELO
        }

    }

}



?>