<?php

//----------------------------------------------------
// CONEXION A LA BD
//----------------------------------------------------

/*
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
*/




class PDOConnection
{
    private static $dbhost = "127.0.0.1";
    private static $dbname = "hauga";
    private static $dbuser = "admin_hauga";
    private static $dbpass = "admin_hauga";
    private static $db_singleton = null;

    public static function getInstance()
    {
        if (self::$db_singleton == null) {
            self::$db_singleton = new PDO(
                "mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname . ";charset=utf8", // connection string
                self::$dbuser,
                self::$dbpass,
                array( // options
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        return self::$db_singleton;
    }
}

?>