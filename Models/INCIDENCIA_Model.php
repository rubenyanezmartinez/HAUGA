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

    function add(){
        $stmt = $this->db->prepare("INSERT INTO incidencia (incidencia_id, descripcion_incid, 
                    estado_incid, espacio_afectado, autor_incidencia) VALUES (?,?,?,?,?)");
        if($stmt->execute(array(null,$this->descripcion_incid, $this->estado_incid,
                $this->espacio_afectado, $this->autor_incidencia))){
            return true;
        }else{
            return 'Error en la inserción de la incidencia';
        }

    }

    function SHOWALL(){
        $stmt = $this->db->prepare("SELECT * FROM incidencia ORDER BY estado_incid");
        $stmt->execute();
        $incidencias_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allIncidencias = array();  //array para almacenar los datos de todas las incidencias

        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($incidencias_db as $incidencia){
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allIncidencias,
                new INCIDENCIA_Model(
                    $incidencia['incidencia_id'], $incidencia['descripcion_incid'], $incidencia['estado_incid']
                    ,$incidencia['espacio_afectado'], $incidencia['autor_incidencia']
                )
            );
        }
        return $allIncidencias;
    }

    public function updateEstado($estadoIncid){
        $stmt = $this->db->prepare("UPDATE incidencia SET estado_incid = ? WHERE incidencia_id = ?");
        $stmt->execute(array($estadoIncid, $this->getIncidenciaId()));
    }
    
    /**
     * @return mixed
     */
    public function getIncidenciaId()
    {
        return $this->incidencia_id;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setIncidenciaId($incidencia_id)
    {
        $this->incidencia_id = $incidencia_id;
    }

    /**
     * @return mixed
     */
    public function getDescripcionIncid()
    {
        return $this->descripcion_incid;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setDescripcionIncid($descripcion_incid)
    {
        $this->descripcion_incid = $descripcion_incid;
    }

    /**
     * @return mixed
     */
    public function getEstadoIncid()
    {
        return $this->estado_incid;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setEstadoIncid($estado_incid)
    {
        $this->estado_incid = $estado_incid;
    }

    /**
     * @return mixed
     */
    public function getEspacioAfectado()
    {
        return $this->espacio_afectado;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setEspacioAfectado($espacio_afectado)
    {
        $this->espacio_afectado = $espacio_afectado;
    }

    /**
     * @return mixed
     */
    public function getAutorIncidencia()
    {
        return $this->autor_incidencia;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setAutorIncidencia($autor_incidencia)
    {
        $this->autor_incidencia = $autor_incidencia;
    }
}
?>