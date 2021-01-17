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

    function edit(){
        $stmt = $this->db->prepare("UPDATE espacio SET nombre_esp=?, tarifa_esp=?, categoria_esp=?, ruta_imagen=? WHERE espacio_id=?");
        if($stmt->execute(array($this->nombre_esp, $this->tarifa_esp, $this->categoria_esp, $this->ruta_imagen ,$this->espacio_id))){
            return true;
        } else {
            return "Error Editando";
        }
    }

    //NO TENER EN CUENTA ESTA MIERDA DE CÓDIGO, ESTAMOS A PUNTO DE DEJAR EL MÁSTER
    function search($depart_espacio, $area_conc_search, $grupo_espacio,
                    $puesto_search, $responsable_espacio, $nivel_search, $agrupacion_espacio, $edificio_espacio, $centros){

        $allEspacios = array();  //array para almacenar los datos de todos los usuarios
        if(!$agrupacion_espacio == "") {
            foreach ($agrupacion_espacio as $a) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE edificio_esp IN(select edificio_id from edificio where agrup_edificio = ?) ");
                $stmt->execute(array($a));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }
        if(!$edificio_espacio == "") {
            foreach ($edificio_espacio as $ed) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE edificio_esp = ? ");
                $stmt->execute(array($ed));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }

        if(!$depart_espacio == "") {
            foreach ($depart_espacio as $de) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE edificio_esp IN(select edificio_depart from departamento where depart_id = ?) ");
                $stmt->execute(array($de));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }

        if(!$centros == "") {
            foreach ($centros as $ce) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE edificio_esp IN(select edificio_centro from centro where centro_id = ?) ");
                $stmt->execute(array($ce));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }

        if(!$responsable_espacio == "") {
            foreach ($responsable_espacio as $re) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id = ? and (estado_solic = ? or estado_solic = ?)) ");
                $stmt->execute(array($re, 'DEFIN', 'TEMP'));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }

        if(!$grupo_espacio == "") {
            foreach ($grupo_espacio as $gr) {
                $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id  in (select responsable_grupo from grupo_investigacion where grupo_id = ?) and (estado_solic = ? or estado_solic = ?)) ");
                $stmt->execute(array($gr, 'DEFIN', 'TEMP'));
                $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);


                //Recorremos todos las filas de usuario devueltas por la sentencia sql
                foreach ($espacios_db as $espacio) {
                    //Introducimos uno a uno los usuarios recuperados de la BD
                    array_push($allEspacios,
                        new ESPACIO_Model(
                            $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                            , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                        )
                    );
                }
            }
        }

        $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id  in (select responsable_grupo from grupo_investigacion where area_conoc_grupo = ?) and (estado_solic = ? or estado_solic = ?)) ");
        $stmt->execute(array($area_conc_search, 'DEFIN', 'TEMP'));
        $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($espacios_db as $espacio) {
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allEspacios,
                new ESPACIO_Model(
                    $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                    , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                )
            );
        }

        $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id  in (select responsable_depart from departamento where area_conc_depart = ?) and (estado_solic = ? or estado_solic = ?)) ");
        $stmt->execute(array($area_conc_search, 'DEFIN', 'TEMP'));
        $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($espacios_db as $espacio) {
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allEspacios,
                new ESPACIO_Model(
                    $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                    , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                )
            );
        }

        $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id  in (select usuario_id from usuario where nivel_jerarquia = ?) and (estado_solic = ? or estado_solic = ?)) ");
        $stmt->execute(array($nivel_search, 'DEFIN', 'TEMP'));
        $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($espacios_db as $espacio) {
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allEspacios,
                new ESPACIO_Model(
                    $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                    , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                )
            );
        }

        $stmt = $this->db->prepare("SELECT * FROM espacio WHERE espacio_id IN(select espacio_id from solicitud_responsabilidad where usuario_id  in (select usuario_id from usuario where nombre_puesto = ?) and (estado_solic = ? or estado_solic = ?)) ");
        $stmt->execute(array($puesto_search, 'DEFIN', 'TEMP'));
        $espacios_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //Recorremos todos las filas de usuario devueltas por la sentencia sql
        foreach ($espacios_db as $espacio) {
            //Introducimos uno a uno los usuarios recuperados de la BD
            array_push($allEspacios,
                new ESPACIO_Model(
                    $espacio['espacio_id'], $espacio['nombre_esp'], $espacio['ruta_imagen']
                    , $espacio['tarifa_esp'], $espacio['categoria_esp'], $espacio['planta_esp'], $espacio['edificio_esp']
                )
            );
        }

        $arrayFinal = array();
        foreach ($allEspacios as $espacio){
            if(!in_array($espacio, $arrayFinal)){
                array_push($arrayFinal, $espacio);
            }
        }
        return $arrayFinal;
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