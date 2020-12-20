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

        $stmt = $this->db->prepare("SELECT *
					FROM departamento
					WHERE depart_id = ?");

        $stmt->execute(array($this->depart_id));
        $departamento = $stmt->fetch(PDO::FETCH_ASSOC);

        if($departamento != null){
            return new DEPARTAMENTO_Models($departamento["depart_id"], $departamento["nombre_depart"],$departamento["codigo_depart"],$departamento["telef_depart"],
        $departamento["email_depart"],$departamento["area_conc_depart"],$departamento["responsable_depart"],$departamento["edificio_depart"]);
        }else {
            return 'Error';
        }

    }

    //Realiza un ADD sobre la tabla departamento. Devuelve un mensaje informando del resultado.
    function registrar(){

        //Comprueba si existe un departamento con el codigo especificado
        if($this->existCodigo()){
            return "Ya existe el código";
        }

        $stmt = $this->db->prepare("INSERT into departamento
                    (depart_id, nombre_depart, codigo_depart, telef_depart, email_depart, area_conc_depart, responsable_depart, edificio_depart) 
					VALUES
					(?,?,?,?,?,?,?,?)");

        if( $stmt->execute(array(null, $this->nombre_depart, $this->codigo_depart, $this->telef_depart, $this->email_depart, $this->area_conc_depart, $this->responsable_depart,
            $this->edificio_depart))){
            return true;
        }else{
            return "Error insertando el departamento";
        }


    }

    //Devuelte true si existe un departamento con el código del objeto
    function existCodigo(){
        $stmt = $this->db->prepare("SELECT *
					FROM departamento
					WHERE codigo_depart = ?");
        $stmt->execute(array($this->codigo_depart));
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if($resultado != false){
            return true;
        }

    }

    //Devuelve un array de departamento con todos los departamento de la tabla.
    function SHOWALL(){

        $stmt = $this->db->prepare("SELECT * FROM departamento");
        $stmt->execute();
        $departamentos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $alldepartamentos = array();  //array para almacenar los datos de todos los grupos

        //Recorremos todos las filas de grupos devueltas por la sentencia sql
        foreach ($departamentos_db as $departamento){
            //Introducimos uno a uno los grupos recuperados de la BD
            array_push($alldepartamentos,
                new DEPARTAMENTO_Models(
                    $departamento['depart_id'],$departamento['nombre_depart'],$departamento['codigo_depart']
                    ,$departamento['telef_depart'],$departamento['email_depart'],$departamento['area_conc_depart'],$departamento['responsable_depart'],
                    $departamento['edificio_depart'])
            );
        }
        return $alldepartamentos;
    }

    function actualizarResponsable(){

        $stmt = $this->db->prepare("UPDATE departamento set responsable_depart = ? where responsable_depart = ?");

        if( $stmt->execute(array(NULL, $this->responsable_depart))){
            return true;
        }else{
            return "Error ACTUALIZANDO";
        }


    }

    function DELETE(){

        $stmt = $this->db->prepare("DELETE
                FROM departamento
                WHERE depart_id = ? ");

        if( $stmt->execute(array($this->depart_id))){
            return true;
        }else{
            return "Error eliminando el departamento";
        }
    }

    /**
     * @return mixed
     */
    function getNombreDepartamento(){
        return $this->nombre_depart;
    }

    /**
     * @return PDO|null
     */


    /**
     * @return mixed
     */
    public function getDepartId()
    {
        return $this->depart_id;
    }

    /**
     * @param mixed $depart_id
     */
    public function setDepartId($depart_id)
    {
        $this->depart_id = $depart_id;
    }

    /**
     * @return mixed
     */
    public function getNombreDepart()
    {
        return $this->nombre_depart;
    }

    /**
     * @param mixed $nombre_depart
     */
    public function setNombreDepart($nombre_depart)
    {
        $this->nombre_depart = $nombre_depart;
    }

    /**
     * @return mixed
     */
    public function getCodigoDepart()
    {
        return $this->codigo_depart;
    }

    /**
     * @param mixed $codigo_depart
     */
    public function setCodigoDepart($codigo_depart)
    {
        $this->codigo_depart = $codigo_depart;
    }

    /**
     * @return mixed
     */
    public function getTelefDepart()
    {
        return $this->telef_depart;
    }

    /**
     * @param mixed $telef_depart
     */
    public function setTelefDepart($telef_depart)
    {
        $this->telef_depart = $telef_depart;
    }

    /**
     * @return mixed
     */
    public function getEmailDepart()
    {
        return $this->email_depart;
    }

    /**
     * @param mixed $email_depart
     */
    public function setEmailDepart($email_depart)
    {
        $this->email_depart = $email_depart;
    }

    /**
     * @return mixed
     */
    public function getAreaConcDepart()
    {
        return $this->area_conc_depart;
    }

    /**
     * @param mixed $area_conc_depart
     */
    public function setAreaConcDepart($area_conc_depart)
    {
        $this->area_conc_depart = $area_conc_depart;
    }

    /**
     * @return mixed
     */
    public function getResponsableDepart()
    {
        return $this->responsable_depart;
    }

    /**
     * @param mixed $responsable_depart
     */
    public function setResponsableDepart($responsable_depart)
    {
        $this->responsable_depart = $responsable_depart;
    }

    /**
     * @return mixed
     */
    public function getEdificioDepart()
    {
        return $this->edificio_depart;
    }

    /**
     * @param mixed $edificio_depart
     */
    public function setEdificioDepart($edificio_depart)
    {
        $this->edificio_depart = $edificio_depart;
    }

}
?>