<?php

include_once 'Access_DB.php';

class SOLICITUD_RESPONSABILIDAD_Model
{
    private $db;
    var $espacio_id;
    var $usuario_id;
    var $fecha;
    var $estado_solic;

    /**
     * SOLICITUD_RESPONSABILIDAD_Model constructor.
     * @param $espacio_id
     * @param $usuario_id
     * @param $fecha
     * @param $estado_solic
     */
    public function __construct($espacio_id, $usuario_id, $fecha, $estado_solic)
    {
        $this->espacio_id = $espacio_id;
        $this->usuario_id = $usuario_id;
        $this->fecha = $fecha;
        $this->estado_solic = $estado_solic;

        $this->db = PDOConnection::getInstance();
    }

    function SHOWALL(){
        $stmt = $this->db->prepare("SELECT * FROM solicitud_responsabilidad WHERE espacio_id = ? and estado_solic LIKE ? ORDER BY fecha DESC");
        $stmt->execute(array($this->espacio_id, 'HISTOR'));
        $stmt->execute();
        $solicitudes_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allSolicitudes = array();


        foreach ($solicitudes_db as $solicitud){
            array_push($allSolicitudes,
                new SOLICITUD_RESPONSABILIDAD_Model(
                    $solicitud['espacio_id'], $solicitud['usuario_id'], $solicitud['fecha'], $solicitud['estado_solic']
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
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