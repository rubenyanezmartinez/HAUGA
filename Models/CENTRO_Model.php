<?php
include_once 'Access_DB.php';

class CENTRO_Model{
    private $db;

    var $centro_id;
    var $nombre_centro;
    var $edificio_centro;


    //Crea un objeto CENTRO
    function __construct($centro_id,
                         $nombre_centro,
                         $edificio_centro){

        $this->centro_id = $centro_id;
        $this->nombre_centro = $nombre_centro;
        $this->edificio_centro = $edificio_centro;


        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de un grupo de investigacion a partir de su grupo_id
    function rellenaDatos(){

        $stmt = $this->db->prepare("SELECT *
					FROM centro
					WHERE centro_id = ?");

        $stmt->execute(array($this->centro_id));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->centro_id = $resultado["centro_id"];
        $this->nombre_centro = $resultado["nombre_centro"];
        $this->edificio_centro = $resultado["edificio_centro"];

        return $resultado;
    }

    //Devuelve un array de centros con todos los centros de la tabla.
    function SHOWALL(){

        $stmt = $this->db->prepare("SELECT * FROM centro");
        $stmt->execute();
        $centros_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allcentros = array();  //array para almacenar los datos de todos los grupos

        //Recorremos todos las filas de grupos devueltas por la sentencia sql
        foreach ($centros_db as $centro){
            //Introducimos uno a uno los grupos recuperados de la BD
            array_push($allcentros,
                new CENTRO_Model(
                    $centro['centro_id'],$centro['nombre_centro'],$centro['edificio_centro']
                )
            );
        }
        return $allcentros;
    }

    /**
     * @return mixed
     */
    function getNombreCentro(){
        return $this->nombre_centro;
    }
}
?>