<?php

//----------------------------------------------------
// CONEXION A LA BD
//----------------------------------------------------


function ConnectDB()
{
    $mysqli = new mysqli("localhost", 'admin_hauga', 'admin_hauga' , 'hauga');
    	
	if ($mysqli->connect_errno) {
		//include './MESSAGE_View.php';
		//new MESSAGE("Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error, './index.php');
		console.log("Error al conectar con la base de datos");
        return false;
	}
	else{
		return $mysqli;
	}
}

?>