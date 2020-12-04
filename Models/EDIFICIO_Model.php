<?php
include_once 'Access_DB.php';

class EDIFICIO_Model{
    private $db;

    var $edificio_id;
    var $nombre_edif;
    var $direccion_edif;
    var $telef_edif;
    var $num_plantas;
    var $agrup_edificio;


    //Crea un objeto EDIFICIO
    function __construct($edificio_id,
                         $nombre_edif,
                         $direccion_edif,
                         $telef_edif,
                         $num_plantas,
                         $agrup_edificio){

        $this->edificio_id = $edificio_id;
        $this->nombre_edif = $nombre_edif;
        $this->direccion_edif = $direccion_edif;
        $this->telef_edif = $telef_edif;
        $this->num_plantas = $num_plantas;
        $this->agrup_edificio = $agrup_edificio;


        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de un edificio a partir de su edificio_id
    function rellenaDatos(){

        $stmt = $this->db->prepare("SELECT *
					FROM edificio
					WHERE edificio_id = ?");

        $stmt->execute(array($this->edificio_id));
        $edificio = $stmt->fetch(PDO::FETCH_ASSOC);

        if($edificio != null){
            return new EDIFICIO_Model($edificio["nombre_edif"],$edificio["direccion_edif"],$edificio["telef_edif"],
                $edificio["num_plantas"],$edificio["agrup_edificio"]);
        }else {
            return  'Error inesperado al intentar cumplir su solicitud de consulta';
        }

    }

    //Devuelve un array de edificio con todos los edificios de la tabla.
    function SHOWALL(){

        $stmt = $this->db->prepare("SELECT * FROM edificio");
        $stmt->execute();
        $edificios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $alledificios = array();  //array para almacenar los datos de todos los edificios

        //Recorremos todos las filas de edificios devueltas por la sentencia sql
        foreach ($edificios_db as $edificio){
            //Introducimos uno a uno los edificios recuperados de la BD
            array_push($alledificios,
                new EDIFICIO_Model(
                    $edificio['edificio_id'],$edificio['nombre_edif'],$edificio['direccion_edif']
                    ,$edificio['telef_edif'],$edificio['num_plantas'],$edificio['agrup_edificio']
                    )
            );
        }
        return $alledificios;
    }
/*
    function actualizarResponsable(){

        $stmt = $this->db->prepare("UPDATE departamento set responsable_depart = ? where responsable_depart = ?");

        if( $stmt->execute(array(NULL, $this->responsable_depart))){
            return true;
        }else{
            return "Error ACTUALIZANDO";
        }


    }*/

    /**
     * @return mixed
     */
    function getNombreEdificio(){
        return $this->nombre_edif;
    }
}
?>