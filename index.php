<?php
//entrada a la aplicacion

//session
echo('index');
session_start();
//incluir funcion autenticacion

include './Functions/Authentication.php';
//si no esta autenticado
if (!IsAuthenticated()){
    header('Location: ./Controllers/User_Controller.php');
} else{   //esta autenticado
    include './Models/USUARIO_Model.php';
    $usuario = new USUARIO_Model(null, $_SESSION['login'],'','','','','','',
        '','','','', '','','','');
    $usuario->RellenaDatos();

    if($usuario->rol == 'ADMIN'){
        include './Views/index_admin.php';
        new AdminIndex();
    } else{
        include './Views/index_usuario.php';
        new Index();
    }

}

?>