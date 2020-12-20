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
            return new EDIFICIO_Model($this->edificio_id, $edificio["nombre_edif"],$edificio["direccion_edif"],$edificio["telef_edif"],
                $edificio["num_plantas"],$edificio["agrup_edificio"]);
        }else {
            return  'Error inesperado al intentar cumplir su solicitud de consulta';
        }

    }

    //Añade un nuevo edificio a la base de datos
    function add(){
        $stmt = $this->db->prepare('INSERT INTO edificio VALUES (?,?,?,?,?,?)');
        if($stmt->execute(array(null, $this->nombre_edif,$this->direccion_edif,
            $this->telef_edif, $this->num_plantas, $this->agrup_edificio))){
            $this->edificio_id = $this->db->lastInsertId();
            return true;
        }else{
            return 'Error insertando el edificio';
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

    function devolverNumeroEdificioAgrupacion(){
        $stmt = $this->db->prepare("SELECT *
                                                FROM edificio
                                                WHERE agrup_edificio = ?");

        $stmt->execute(array($this->getAgrup_edificio()));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if($resultado != null){
            return count($resultado);
        }else {
            return  0;
        }
    }

    function devolverEdificiosPorAgrupacion(){
        $stmt = $this->db->prepare("SELECT *
                                                FROM edificio
                                                WHERE agrup_edificio = ?");

        $stmt->execute(array($this->getAgrup_edificio()));
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($resultado != null){
            return $resultado;
        }else {
            return  0;
        }
    }

    function getNombreById(){
        $stmt = $this->db->prepare("SELECT nombre_edif FROM edificio WHERE edificio_id = ?");
        $stmt->execute(array($this->edificio_id));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if($resultado != null){
            return $resultado['nombre_edif'];
        }else{
            return 'No existe el edificio en la BD';
        }
    }

    //Modifica los datos del edificio
    //Devuelve true si se ejecuta la sentencia, mensaje de error en caso contrario
    function EDIT(){
        $stmt = $this->db->prepare("UPDATE edificio SET
                    nombre_edif = ?, telef_edif = ?, agrup_edificio = ?
					WHERE edificio_id = ?");
        $resultado = $stmt->execute(array($this->nombre_edif, $this->telef_edif, $this->agrup_edificio,
            $this->edificio_id));

        if($resultado === true){
            return true;
        }else{
            return 'Error inesperado al intentar cumplir su solicitud de modificacion';
        }
    }

    function DELETE(){

        $stmt = $this->db->prepare("DELETE
                FROM edificio
                WHERE edificio_id = ? ");

        if( $stmt->execute(array($this->edificio_id))){
            return true;
        }else{
            return "Error eliminando el edificio";
        }
    }

    /**
     * @return mixed
     */
    function getNombreEdificio(){
        return $this->nombre_edif;
    }
    /**
     * @return mixed
     */
    function getAgrup_edificio(){
        return $this->agrup_edificio;
    }
    /**
     * @param mixed $edificio_id
     */
    function setAgrup_edificio($agrup_edificio){
        $this->agrup_edificio = $agrup_edificio;
    }

    /**
     * @return mixed
     */
    public function getEdificioId()
    {
        return $this->edificio_id;
    }

    /**
     * @param mixed $edificio_id
     */
    public function setEdificioId($edificio_id)
    {
        $this->edificio_id = $edificio_id;
    }

    /**
     * @return mixed
     */
    public function getNombreEdif()
    {
        return $this->nombre_edif;
    }

    /**
     * @param mixed $nombre_edif
     */
    public function setNombreEdif($nombre_edif)
    {
        $this->nombre_edif = $nombre_edif;
    }

    /**
     * @return mixed
     */
    public function getDireccionEdif()
    {
        return $this->direccion_edif;
    }

    /**
     * @param mixed $direccion_edif
     */
    public function setDireccionEdif($direccion_edif)
    {
        $this->direccion_edif = $direccion_edif;
    }

    /**
     * @return mixed
     */
    public function getTelefEdif()
    {
        return $this->telef_edif;
    }

    /**
     * @param mixed $telef_edif
     */
    public function setTelefEdif($telef_edif)
    {
        $this->telef_edif = $telef_edif;
    }

    /**
     * @return mixed
     */
    public function getNumPlantas()
    {
        return $this->num_plantas;
    }

    /**
     * @param mixed $num_plantas
     */
    public function setNumPlantas($num_plantas)
    {
        $this->num_plantas = $num_plantas;
    }
}
?>