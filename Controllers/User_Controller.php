<?php
include '../Views/LOGIN_View.php';
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
session_start();


if(!IsAuthenticated()){
    login();
}else{
    if(!isset($_GET['action'])){
        $action = '';
    } else{
        $action = $_GET['action'];
    }

    switch($action){

        case 'showall': showall();
            break;
        case 'logout': logout();
            break;
        //Caso default para vista de error generico
        default: echo('default del switch user_controller');
            break;
    }
}


function login(){


    if(!isset($_POST['login']) && !isset($_POST['password'])){    //Si no estan instanciadas login y password

        $login = new Login_view();  //Muestra vista de login
    } else{ //Si se recibieron el login y la password

        $usuario = new USUARIO_Model(null, $_POST['login'], "", "",$_POST['password'], ""
            ,"","","","","","",
            "","","","");
        $existLogin = $usuario->existLogin();

        if($existLogin === true){   //Si existe el login en la BD
            $respuesta = $usuario->login();

            if($respuesta === true){ //Si coincide la contraseña dada con la del usuario
                session_start();
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['rol'] = $usuario->getRol();

                header('Location:../index.php');
            }else{
                //Mostramos datos introducidos y mensaje de error de que no coincide la password
                $login = new LOGIN_View(["login" => $_POST['login'], "password" => $_POST['password'], "respuesta"=>$respuesta]);

            }
        }else{  //No existe el login en la BD y se devuelve mensaje
            //Mostramos mensaje de error de que no existe dicho usuario
            $login = new LOGIN_View(["login" => $_POST['login'], "password" => $_POST['password'], "respuesta" => $existLogin]);
        }


    }

}


function showall(){
    $usuario = new USUARIO_Model('','','','','','','','','','','','','','','','');  //Crea un USUARIO vacio
    $AllUsuarios = $usuario->SHOWALL(); //En $AllUsuarios se guarda el array de USUARIOs que devuelve el SHOWALL con todos los USUSARIOs registrados
    include '../Views/USUARIO_SHOWALL_View.php';    //Incluye fichero php con la vista SHOWALL
    new USUARIO_SHOWALL_View($AllUsuarios);//LLama al constructor de Usuario_Showall, que muestra la tabla
}


function logout(){
    logoutSession();   //De Desconectar.php
}



?>