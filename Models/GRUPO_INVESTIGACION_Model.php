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

        /**
         * @return mixed
         */
        function getNombreGrupo(){
            return $this->nombre_grupo;
        }
    }
?>