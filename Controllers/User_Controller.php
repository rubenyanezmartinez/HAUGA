<?php
include '../Views/LOGIN_View.php';
include '../Functions/Authentication.php';
//include '../Models/Access_DB.php';
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

        default: //Caso por defecto, muestra todos los usuarios.
            $usuario = new USUARIO_Model('','','','','','','','','','','','','','','',''); //Crea un USUARIO vacío
            $AllUsuarios = $usuario->SHOWALL(); //En $AllUsuarios se guarda el array de USUARIOs que devuelte el SHOWALL con todos los USUARIOs registrados
            include '../Views/USUARIO_SHOWALL_View.php'; //Incluye el fichero php con la vista del SHOWALL
            new USUARIO_SHOWALL_View($AllUsuarios); //Llama al constructor de Usuario_Showall, que muestra la tabla.
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