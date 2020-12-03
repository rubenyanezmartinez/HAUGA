<?php
include_once 'Access_DB.php';

class AGRUPACION_Model{
    private $db;

    var $agrup_id;
    var $nombre_agrup;
    var $ubicacion_agrup;

    //Crea un objeto AGRUPACIÓN
    function __construct($agrup_id, $nombre_agrup, $ubicacion_agrup)
    {
        $this->agrup_id = $agrup_id;
        $this->nombre_agrup = $nombre_agrup;
        $this->ubicacion_agrup = $ubicacion_agrup;

        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de una agrupación de edificios a partir de su id
    function rellenaDatos(){
        $stmt = $this->db->prepare("SELECT *
                                    FROM agrupacion_edificio
                                    WHERE agrup_id = ?");
        $stmt->execute(arra($this->agrup_id));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->agrup_id = $resultado["agrup_id"];
        $this->nombre_agrup = $resultado["nombre_agrup"];
        $this->ubicacion_agrup = $resultado["ubicacion_agrup"];

        return $resultado;
    }

    //Devuelve un array de agrupaciones con todas las agurpaciones de la tabla
    function SHOWALL(){
        $stmt = $this->db->prepare("SELECT * FROM agrupacion_edificio");
        $stmt->execute();
        $agrup_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allAgrup = array();

        //Recorremos todas las filas de agrupaciones devueltas por la sentencia sql
        foreach($agrup_db as $agrup){
            array_push($allAgrup,
                new AGRUPACION_Model(
                    $agrup["agrup_id"], $agrup["nombre_agrup"], $agrup['ubicacion_agrup']
                )
            );
        }
        return $allAgrup;
    }
}
?>