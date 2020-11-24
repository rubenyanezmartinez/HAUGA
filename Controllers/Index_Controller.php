<?php


//session
session_start();
//incluir funcion autenticacion
include '../Functions/Authentication.php';
//si no esta autenticado
if (!IsAuthenticated()){
	header('Location: ../index.php');
}
//esta autenticado
else{
	include '../Models/USUARIO_Model.php';
	$usuario = new USUARIO_Model($_SESSION['login'],'','','','','','','','','','');
	$usuario->RellenaDatos();
	
	if($usuario->administrador == 'si'){
		include '../Views/admin_index_View.php';
		new Index();
	} else if($usuario->pujador == 'si'){
		include '../Views/users_index_View.php';
		new Index();
	} else {
		include '../Views/MESSAGE_View.php';
		session_destroy();
		new MESSAGE('Usuario pendiente de autorización', '../index.php');
	}

}

?>