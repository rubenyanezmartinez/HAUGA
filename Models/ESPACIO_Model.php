<?php

include_once 'Access_DB.php';

class ESPACIO_Model
{
    private $db;

    var $espacio_id;
    var $nombre_esp;
    var $ruta_imagen;
    var $tarifa_esp;
    var $categoria_esp;
    var $planta_esp;
    var $edificio_esp;

    /**
     * ESPACIO_Model constructor.
     * @param $espacio_id
     * @param $nombre_esp
     * @param $ruta_imagen
     * @param $tarifa_esp
     * @param $categoria_esp
     * @param $planta_esp
     * @param $edificio_esp
     */
    public function __construct($espacio_id, $nombre_esp, $ruta_imagen, $tarifa_esp, $categoria_esp, $planta_esp, $edificio_esp)
    {
        $this->espacio_id = $espacio_id;
        $this->nombre_esp = $nombre_esp;
        $this->ruta_imagen = $ruta_imagen;
        $this->tarifa_esp = $tarifa_esp;
        $this->categoria_esp = $categoria_esp;
        $this->planta_esp = $planta_esp;
        $this->edificio_esp = $edificio_esp;

        $this->db = PDOConnection::getInstance();
    }


    function DELETE(){
        $stmt = $this->db->prepare("DELETE
					FROM espacio
					WHERE espacio_id = ? ");

        if($stmt->execute(array($this->espacio_id))){
            return true;
        }else{
            return "Error eliminando espacio.";
        }
    }

    function SHOWALL(){
        $stmt = $this->db->prepare("SELECT * FROM espacio ORDER BY edificio_esp");
        $stmt->execute();
        $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allEspacios = array();  //array para almacenar los datos de todos los usuarios

        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($espacios_db as $espacio){
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allEspacios,
                new ESPACIO_Model(
                    $espacio['espacio_id'],$espacio['nombre_esp'],$espacio['ruta_imagen']
                    ,$espacio['tarifa_esp'],$espacio['categoria_esp'],$espacio['planta_esp'],$espacio['edificio_esp']
                )
            );
        }
        return $allEspacios;
    }

    function rellenaDatos(){
        $stmt = $this->db->prepare("SELECT *
					FROM espacio
					WHERE espacio_id = ?");

        $stmt->execute(array($this->espacio_id));

        $espacio = $stmt->fetch(PDO::FETCH_ASSOC);

        if($espacio != null){
            $resultado = new ESPACIO_Model(
                $espacio['espacio_id'],$espacio['nombre_esp'],$espacio['ruta_imagen']
                ,$espacio['tarifa_esp'],$espacio['categoria_esp'],$espacio['planta_esp'],$espacio['edificio_esp']
            );

            return $resultado;


        }else{
            return  'Error inesperado al intentar cumplir su solicitud de consulta';
        }

    }

    function add(){
        $stmt = $this->db->prepare("INSERT into espacio VALUES (?,?,?,?,?,?,?)");
        if($stmt->execute(array(null, $this->nombre_esp, $this->ruta_imagen, $this->tarifa_esp, $this->categoria_esp, $this->planta_esp, $this->edificio_esp))){
            $this->espacio_id = $this->db->lastInsertId();
            return true;
        } else {
            return "Error Insertando";
        }
    }

    function borrarEspaciosEdificio(){
        $stmt = $this->db->prepare("DELETE
					FROM espacio
					WHERE edificio_esp = ? ");

        if($stmt->execute(array($this->edificio_esp))){
            return true;
        }else{
            return "Error eliminando espacios.";
        }
    }

    function edit(){
        $stmt = $this->db->prepare("UPDATE espacio SET nombre_esp=?, tarifa_esp=?, categoria_esp=? WHERE espacio_id=?");
        if($stmt->execute(array($this->nombre_esp, $this->tarifa_esp, $this->categoria_esp, $this->espacio_id))){
            return true;
        } else {
            return "Error Editando";
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
    public function getNombreEsp()
    {
        return $this->nombre_esp;
    }

    /**
     * @param mixed $nombre_esp
     */
    public function setNombreEsp($nombre_esp)
    {
        $this->nombre_esp = $nombre_esp;
    }

    /**
     * @return mixed
     */
    public function getRutaImagen()
    {
        return $this->ruta_imagen;
    }

    /**
     * @param mixed $ruta_imagen
     */
    public function setRutaImagen($ruta_imagen)
    {
        $this->ruta_imagen = $ruta_imagen;
    }

    /**
     * @return mixed
     */
    public function getTarifaEsp()
    {
        return $this->tarifa_esp;
    }

    /**
     * @param mixed $tarifa_esp
     */
    public function setTarifaEsp($tarifa_esp)
    {
        $this->tarifa_esp = $tarifa_esp;
    }

    /**
     * @return mixed
     */
    public function getCategoriaEsp()
    {
        return $this->categoria_esp;
    }

    /**
     * @param mixed $categoria_esp
     */
    public function setCategoriaEsp($categoria_esp)
    {
        $this->categoria_esp = $categoria_esp;
    }

    /**
     * @return mixed
     */
    public function getPlantaEsp()
    {
        return $this->planta_esp;
    }

    /**
     * @param mixed $planta_esp
     */
    public function setPlantaEsp($planta_esp)
    {
        $this->planta_esp = $planta_esp;
    }

    /**
     * @return mixed
     */
    public function getEdificioEsp()
    {
        return $this->edificio_esp;
    }

    /**
     * @param mixed $edificio_esp
     */
    public function setEdificioEsp($edificio_esp)
    {
        $this->edificio_esp = $edificio_esp;
    }

}

?>