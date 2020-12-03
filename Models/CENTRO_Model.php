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

        $sql="SELECT * FROM centro WHERE (`centro_id` LIKE '".$this->centro_id."')";

        $resultado=$this->mysqli->query($sql);

        $registro=mysqli_fetch_array($resultado);

        $this->centro_id = $registro["centro_id"];
        $this->nombre_centro = $registro["nombre_centro"];
        $this->edificio_centro = $registro["edificio_centro"];

        return $registro;
    }

    /**
     * @return mixed
     */
    function getNombreCentro(){
        return $this->nombre_centro;
    }
}
?>