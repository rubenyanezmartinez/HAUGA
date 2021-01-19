<?php


//session
session_start();
//incluir funcion autenticacion
include_once '../Functions/Authentication.php';
//si no esta autenticado
if (!IsAuthenticated()){
    header('Location:../Controllers/Incidencia_Controller.php?action=add');
} else{   //esta autenticado
	//include '../Models/USUARIO_Model.php';
	//$usuario = new USUARIO_Model(null, $_SESSION['login'],'','','','','','',
    //    '','','','', '','','','');
	//$usuario->RellenaDatos();

	include_once('../Functions/esAdministrador.php');
	if(esAdministrador()) {
        include '../Views/index_admin.php';
        new AdminIndex();
	} else{
        header('Location:../Controllers/Incidencia_Controller.php?action=add');

    }
	//if($usuario->rol == 'ADMIN'){
	//	include '../Views/index_admin.php';
	//	new AdminIndex();
	//} else{
	//	include '../Views/index_usuario.php';
	//	new Index();
	//}

}

?>