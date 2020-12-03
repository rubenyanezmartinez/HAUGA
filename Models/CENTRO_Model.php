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

    /**
     * @return mixed
     */
    function getNombreCentro(){
        return $this->nombre_centro;
    }
}
?>