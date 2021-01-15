<?php

include_once 'Access_DB.php';

class SOLICITUD_RESPONSABILIDAD_Model
{
    private $db;
    var $solicitud_id;
    var $espacio_id;
    var $usuario_id;
    var $fecha_inicio;
    var $fecha_fin;
    var $estado_solic;
    var $tarifa_historica;


    public function __construct($solicitud_id, $espacio_id, $usuario_id, $fecha_inicio, $fecha_fin, $estado_solic, $tarifa_historica)
    {
        $this->solicitud_id = $solicitud_id;
        $this->espacio_id = $espacio_id;
        $this->usuario_id = $usuario_id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->estado_solic = $estado_solic;
        $this->tarifa_historica = $tarifa_historica;

        $this->db = PDOConnection::getInstance();
    }


    function SHOWALL(){
        $stmt = $this->db->prepare("SELECT * FROM solicitud_responsabilidad WHERE espacio_id = ? and estado_solic LIKE ? ORDER BY fecha_inicio DESC");
        $stmt->execute(array($this->espacio_id, 'HISTOR'));
        $stmt->execute();
        $solicitudes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allSolicitudes = array();


        foreach ($solicitudes_db as $solicitud){
            array_push($allSolicitudes,
                new SOLICITUD_RESPONSABILIDAD_Model(
                    $solicitud['solicitud_id'], $solicitud['espacio_id'], $solicitud['usuario_id'], $solicitud['fecha_inicio'], $solicitud['fecha_fin'], $solicitud['estado_solic'], $solicitud['tarifa_historica']
                )
            );
        }
        return $allSolicitudes;
    }

    /**
     * Devuelve el id del usuario que figura como responsable del espacio, en caso de no existir devuelve un mensaje de error
     * @return mixed|integer
     */
    function buscarResponsable(){
        $stmt = $this->db->prepare("SELECT *  FROM solicitud_responsabilidad WHERE espacio_id = ? and estado_solic LIKE ?");
        $stmt->execute(array($this->espacio_id, 'DEFIN'));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if(count($resultado) == 0){
            return 'Sin responsable';
        }
        else{
            return $resultado["usuario_id"];
        }
    }

    function add(){
        $stmt = $this->db->prepare("INSERT into solicitud_responsabilidad VALUES (?,?,?,?,?,?,?)");
        if($stmt->execute(array(null, $this->espacio_id, $this->usuario_id, $this->fecha_inicio, $this->fecha_fin, $this->estado_solic, $this->tarifa_historica))){
            return true;
        } else {
            return 'Error';
        }
    }

    //-------------Funcion para eliminar solicitudes----------------


    function eliminarResponsable(){
        $stmt = $this->db->prepare("UPDATE solicitud_responsabilidad SET estado_solic='HISTOR', fecha_fin=? WHERE estado_solic='DEFIN' and espacio_id=?");
        $stmt->execute(array(date('Y-m-d'), $this->espacio_id));
    }

    function haSolicitadoEspacio($espacio_id, $usuario_id){
        $stmt = $this->db->prepare("SELECT * FROM solicitud_responsabilidad WHERE espacio_id=? and usuario_id=? and estado_solic=?");
        $resultado = $stmt->execute(array($espacio_id, $usuario_id, 'TEMP'));

        return $stmt->fetch(PDO::FETCH_ASSOC) != false;

    }

    /**
     * @return mixed
     */
    public function getEspacioId()
    {
        return $this->espacio_id;
    }

    /**
     * @param mixed $espacio_id
     */
    public function setEspacioId($espacio_id)
    {
        $this->espacio_id = $espacio_id;
    }

    /**
     * @return mixed
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    /**
     * @param mixed $usuario_id
     */
    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @return mixed
     */
    public function getTarifaHistorica()
    {
        return $this->tarifa_historica;
    }

    /**
     * @param mixed $tarifa_historica
     */
    public function setTarifaHistorica($tarifa_historica)
    {
        $this->tarifa_historica = $tarifa_historica;
    }


    /**
     * @return mixed
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @param mixed $fecha_fin
     */
    public function setFechaFin($fecha_fin)
    {
        $this->fecha_fin = $fecha_fin;
    }


    /**
     * @return mixed
     */
    public function getEstadoSolic()
    {
        return $this->estado_solic;
    }

    /**
     * @param mixed $estado_solic
     */
    public function setEstadoSolic($estado_solic)
    {
        $this->estado_solic = $estado_solic;
    }




}

?>