<?php
include_once 'Access_DB.php';

    class GRUPO_INVESTIGACION_Model{
        private $db;

        var $grupo_id;
        var $nombre_grupo;
        var $telef_grupo;
        var $lineas_investigacion;
        var $area_conoc_grupo;
        var $email_grupo;
        var $responsable_grupo;


        //Crea un objeto GRUPO DE INVESTIGACION
        function __construct($grupo_id,
                             $nombre_grupo,
                             $telef_grupo,
                             $lineas_investigacion,
                             $area_conoc_grupo,
                             $email_grupo,
                             $responsable_grupo){

            $this->grupo_id = $grupo_id;
            $this->nombre_grupo = $nombre_grupo;
            $this->telef_grupo = $telef_grupo;
            $this->lineas_investigacion = $lineas_investigacion;
            $this->area_conoc_grupo = $area_conoc_grupo;
            $this->email_grupo = $email_grupo;
            $this->responsable_grupo = $responsable_grupo;


            $this->db = PDOConnection::getInstance();
        }

        //Recupera los datos de un grupo de investigacion a partir de su grupo_id
        function rellenaDatos(){

            $stmt = $this->db->prepare("SELECT *
					FROM grupo_investigacion
					WHERE grupo_id = ?");

            $stmt->execute(array($this->grupo_id));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->nombre_grupo = $resultado["nombre_grupo"];
            $this->telef_grupo = $resultado["telef_grupo"];
            $this->lineas_investigacion = $resultado["lineas_investigacion"];
            $this->area_conoc_grupo = $resultado["area_conoc_grupo"];
            $this->email_grupo = $resultado["email_grupo"];
            $this->responsable_grupo = $resultado["responsable_grupo"];

            return $resultado;
        }

        //Devuelve un array de GRUPOS con todos los GRUPOS de la tabla.
        function SHOWALL(){

            $stmt = $this->db->prepare("SELECT * FROM grupo_investigacion");
            $stmt->execute();
            $grupos_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allgrupos = array();  //array para almacenar los datos de todos los grupos

            //Recorremos todos las filas de grupos devueltas por la sentencia sql
            foreach ($grupos_db as $grupo){
                //Introducimos uno a uno los grupos recuperados de la BD
                array_push($allgrupos,
                    new GRUPO_INVESTIGACION_Model(
                        $grupo['grupo_id'],$grupo['nombre_grupo'],$grupo['telef_grupo']
                        ,$grupo['lineas_investigacion'],$grupo['area_conoc_grupo'],$grupo['email_grupo'],$grupo['responsable_grupo']
                    )
                );
            }
            return $allgrupos;
        }

        function actualizarResponsable(){

            $stmt = $this->db->prepare("UPDATE grupo_investigacion set responsable_grupo = ? where responsable_grupo = ?");

            if( $stmt->execute(array(NULL, $this->responsable_grupo))){
                return true;
            }else{
                return "Error ACTUALIZANDO";
            }


        }

        /**
         * @return mixed
         */
        function getNombreGrupo(){
            return $this->nombre_grupo;
        }
    }
?>