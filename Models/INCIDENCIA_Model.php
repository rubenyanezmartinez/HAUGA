<?php
include_once 'Access_DB.php';

class INCIDENCIA_Model{
    private $db;

    var $incidencia_id;
    var $descripcion_incid;
    var $estado_incid;
    var $espacio_afectado;
    var $autor_incidencia;


    //Crea un objeto CENTRO
    function __construct($incidencia_id,
                         $descripcion_incid,
                         $estado_incid,
                         $espacio_afectado,
                         $autor_incidencia){

        $this->incidencia_id = $incidencia_id;
        $this->descripcion_incid = $descripcion_incid;
        $this->estado_incid = $estado_incid;
        $this->espacio_afectado = $espacio_afectado;
        $this->autor_incidencia = $autor_incidencia;


        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de una incidencia a partir de su incidencia
    function rellenaDatos(){

        $stmt = $this->db->prepare("SELECT *
					FROM incidencia
					WHERE incidencia_id = ?");

        $stmt->execute(array($this->incidencia_id));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->incidencia_id = $resultado["incidencia_id"];
        $this->descripcion_incid = $resultado["descripcion_incid"];
        $this->estado_incid = $resultado["estado_incid"];
        $this->espacio_afectado = $resultado["espacio_afectado"];
        $this->autor_incidencia = $resultado["autor_incidencia"];

        return $resultado;
    }

    function actualizarAutor(){

        $stmt = $this->db->prepare("UPDATE incidencia set autor_incidencia = ? where autor_incidencia = ?");

        if( $stmt->execute(array(NULL, $this->autor_incidencia))){
            return true;
        }else{
            return "Error ACTUALIZANDO";
        }


    }
}
?>