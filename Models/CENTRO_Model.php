<?php
include_once 'Access_DB.php';

class CENTRO_Model{
    private $db;

    var $centro_id;
    var $nombre_centro;
    var $edificio_centro;


    //Crea un objeto CENTRO
    function __construct($centro_id,
                         $nombre_centro,
                         $edificio_centro){

        $this->centro_id = $centro_id;
        $this->nombre_centro = $nombre_centro;
        $this->edificio_centro = $edificio_centro;


        $this->db = PDOConnection::getInstance();
    }

    //Recupera los datos de un grupo de investigacion a partir de su grupo_id
    function rellenaDatos(){

        $stmt = $this->db->prepare("SELECT *
					FROM centro
					WHERE centro_id = ?");

        $stmt->execute(array($this->centro_id));
        $centro = $stmt->fetch(PDO::FETCH_ASSOC);
        if($centro != null){

            return new CENTRO_Model($centro["centro_id"], $centro["nombre_centro"], $centro["edificio_centro"]);

        }else{
            return  'Error inesperado al intentar cumplir su solicitud de consulta';
        }
    }

    //Devuelve un array de centros con todos los centros de la tabla.
    function SHOWALL(){

        $stmt = $this->db->prepare("SELECT * FROM centro");
        $stmt->execute();
        $centros_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $allcentros = array();  //array para almacenar los datos de todos los centros

        //Recorremos todos las filas de centros devueltas por la sentencia sql
        foreach ($centros_db as $centro){
            //Introducimos uno a uno los grupos recuperados de la BD
            array_push($allcentros,
                new CENTRO_Model(
                    $centro['centro_id'],$centro['nombre_centro'],$centro['edificio_centro']
                )
            );
        }
        return $allcentros;
    }

    function add(){
        $stmt = $this->db->prepare('INSERT INTO centro VALUES (?,?,?)');
        if($stmt->execute(array(null, $this->nombre_centro,$this->edificio_centro))){
            return true;
        }else{
            return 'Error insertando el centro';
        }
    }

    function DELETE(){

        $stmt = $this->db->prepare("DELETE
                FROM centro
                WHERE centro_id = ? ");

        if( $stmt->execute(array($this->centro_id))){
            return true;
        }else{
            return "Error eliminando el centro";
        }
    }



    /**
     * @return mixed
     */
    function getNombreCentro(){
        return $this->nombre_centro;
    }

    /**
     * @return mixed
     */
    public function getCentroId()
    {
        return $this->centro_id;
    }

    /**
     * @param mixed $centro_id
     */
    public function setCentroId($centro_id)
    {
        $this->centro_id = $centro_id;
    }

    /**
     * @return mixed
     */
    public function getEdificioCentro()
    {
        return $this->edificio_centro;
    }

    /**
     * @param mixed $edificio_centro
     */
    public function setEdificioCentro($edificio_centro)
    {
        $this->edificio_centro = $edificio_centro;
    }


}
?>