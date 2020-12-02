<?php
include_once 'Access_DB.php';

class DEPARTAMENTO_Models{
    private $db;

    var $depart_id;
    var $nombre_depart;
    var $codigo_depart;
    var $telef_depart;
    var $email_depart;
    var $area_conc_depart;
    var $responsable_depart;
    var $edificio_depart;


    //Crea un objeto DEPARTAMENTO
    function __construct($depart_id,
                         $nombre_depart,
                         $codigo_depart,
                         $telef_depart,
                         $email_depart,
                         $area_conc_depart,
                         $responsable_depart,
                         $edificio_depart){

        $this->depart_id = $depart_id;
        $this->nombre_depart = $nombre_depart;
        $this->codigo_depart = $codigo_depart;
        $this->telef_depart = $telef_depart;
        $this->email_depart = $email_depart;
        $this->area_conc_depart = $area_conc_depart;
        $this->responsable_depart = $responsable_depart;
        $this->edificio_depart = $edificio_depart;


        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de un grupo de investigacion a partir de su grupo_id
    function rellenaDatos(){

        $sql="SELECT * FROM departamento WHERE (`depart_id` LIKE '".$this->depart_id."')";

        $resultado=$this->mysqli->query($sql);

        $registro=mysqli_fetch_array($resultado);

        $this->nombre_depart = $registro["nombre_depart"];
        $this->codigo_depart = $registro["codigo_depart"];
        $this->telef_depart = $registro["telef_depart"];
        $this->email_depart = $registro["email_depart"];
        $this->area_conc_depart = $registro["area_conc_depart"];
        $this->responsable_depart = $registro["responsable_depart"];
        $this->edificio_depart = $registro["edificio_depart"];

        return $registro;
    }

    /**
     * @return mixed
     */
    function getNombreDepartamento(){
        return $this->nombre_depart;
    }
}
?>