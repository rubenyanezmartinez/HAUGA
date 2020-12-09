<?php
include_once 'Access_DB.php';

class AGRUPACION_Model{
    private $db;

    private $agrup_id;
    private $nombre_agrup;
    private $ubicacion_agrup;

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
        $stmt->execute(array($this->agrup_id));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if($resultado != null){
            $this->agrup_id = $resultado["agrup_id"];
            $this->nombre_agrup = $resultado["nombre_agrup"];
            $this->ubicacion_agrup = $resultado["ubicacion_agrup"];

            return $resultado;
        } else {
            return 'Error';
        }


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

    function add(){
        $stmt = $this->db->prepare('INSERT INTO agrupacion_edificio VALUES (?,?,?)');
        if($stmt->execute(array(null, $this->nombre_agrup, $this->ubicacion_agrup))){
            return true;
        } else {
            return "Error insertando la agrupación";
        }
    }

    function delete(){
        $stmt = $this->db->prepare("DELETE
					FROM agrupacion_edificio
					WHERE agrup_id = ? ");

        if( $stmt->execute(array($this->agrup_id))){
            return true;
        }else{
            return "Error eliminando la agrupación de edificios";
        }
    }

    /**
     * @return mixed
     */
    public function getAgrupId()
    {
        return $this->agrup_id;
    }

    /**
     * @param mixed $agrup_id
     */
    public function setAgrupId($agrup_id)
    {
        $this->agrup_id = $agrup_id;
    }

    /**
     * @return mixed
     */
    public function getNombreAgrup()
    {
        return $this->nombre_agrup;
    }

    /**
     * @param mixed $nombre_agrup
     */
    public function setNombreAgrup($nombre_agrup)
    {
        $this->nombre_agrup = $nombre_agrup;
    }

    /**
     * @return mixed
     */
    public function getUbicacionAgrup()
    {
        return $this->ubicacion_agrup;
    }

    /**
     * @param mixed $ubicacion_agrup
     */
    public function setUbicacionAgrup($ubicacion_agrup)
    {
        $this->ubicacion_agrup = $ubicacion_agrup;
    }
}
?>