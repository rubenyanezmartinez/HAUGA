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
            $grupo = $stmt->fetch(PDO::FETCH_ASSOC);

            if($grupo != null){
                return new GRUPO_INVESTIGACION_Model($grupo["grupo_id"], $grupo["nombre_grupo"],$grupo["telef_grupo"],$grupo["lineas_investigacion"],
                    $grupo["area_conoc_grupo"],$grupo["email_grupo"],$grupo["responsable_grupo"]);
            }else{
                return  'Error inesperado al intentar cumplir su solicitud de consulta';
            }
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

        /**
         * @return mixed
         */
        public function getGrupoId()
        {
            return $this->grupo_id;
        }

        /**
         * @param mixed $grupo_id
         */
        public function setGrupoId($grupo_id)
        {
            $this->grupo_id = $grupo_id;
        }

        /**
         * @return mixed
         */
        public function getTelefGrupo()
        {
            return $this->telef_grupo;
        }

        /**
         * @param mixed $telef_grupo
         */
        public function setTelefGrupo($telef_grupo)
        {
            $this->telef_grupo = $telef_grupo;
        }

        /**
         * @return mixed
         */
        public function getLineasInvestigacion()
        {
            return $this->lineas_investigacion;
        }

        /**
         * @param mixed $lineas_investigacion
         */
        public function setLineasInvestigacion($lineas_investigacion)
        {
            $this->lineas_investigacion = $lineas_investigacion;
        }

        /**
         * @return mixed
         */
        public function getAreaConocGrupo()
        {
            return $this->area_conoc_grupo;
        }

        /**
         * @param mixed $area_conoc_grupo
         */
        public function setAreaConocGrupo($area_conoc_grupo)
        {
            $this->area_conoc_grupo = $area_conoc_grupo;
        }

        /**
         * @return mixed
         */
        public function getEmailGrupo()
        {
            return $this->email_grupo;
        }

        /**
         * @param mixed $email_grupo
         */
        public function setEmailGrupo($email_grupo)
        {
            $this->email_grupo = $email_grupo;
        }

        /**
         * @return mixed
         */
        public function getResponsableGrupo()
        {
            return $this->responsable_grupo;
        }

        /**
         * @param mixed $responsable_grupo
         */
        public function setResponsableGrupo($responsable_grupo)
        {
            $this->responsable_grupo = $responsable_grupo;
        }


    }
?>