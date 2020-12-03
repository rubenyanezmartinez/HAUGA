<?php
include_once 'Access_DB.php';

	class USUARIO_Model{
        private $db;

		var $usuario_id;
		var $login;
		var $nombre;
		var $apellidos;
		var $password;
		var $fecha_nacimiento;
		var $email_usuario;
		var $telef_usuario;
		var $dni;
		var $rol;
		var $afiliacion;
		var $nombre_puesto;
		var $nivel_jerarquia;
		var $depart_usuario;
		var $grupo_usuario;
		var $centro_usuario;
		//var $mysqli;
		
		//Crea un objeto USUARIO
		function __construct($usuario_id,
							 $login,
							 $nombre,
							 $apellidos,
							 $password,
							 $fecha_nacimiento,
							 $email_usuario,
							 $telef_usuario,
							 $dni,
							 $rol,
							 $afiliacion,
							 $nombre_puesto,
							 $nivel_jerarquia,
							 $depart_usuario,
							 $grupo_usuario,
							 $centro_usuario){
			$this->usuario_id = $usuario_id;
			$this->login = $login;
			$this->nombre = $nombre;
			$this->apellidos = $apellidos;
			$this->password = $password;
			$this->fecha_nacimiento = $fecha_nacimiento;
			$this->email_usuario = $email_usuario;
			$this->telef_usuario = $telef_usuario;
			$this->dni = $dni;
			$this->rol = $rol;
			$this->afiliacion = $afiliacion;
			$this->nombre_puesto = $nombre_puesto;
			$this->nivel_jerarquia = $nivel_jerarquia;
			$this->depart_usuario = $depart_usuario;
			$this->grupo_usuario = $grupo_usuario;
			$this->centro_usuario = $centro_usuario;

			$this->db = PDOConnection::getInstance();
		}


        //-------------------------------FUNCIONES QUE USAN SENTENCIAS SQL----------------------------------


		//Realiza un ADD sobre la tabla USUARIO. Devuelve un mensaje informando del resultado.
		function registrar(){

			$this->login = $this->generarLogin();

			//Comprueba si existe un usuario con el DNI especificado
			if($this->existDNI()){
				return "Ya existe el DNI";
			}

            $stmt = $this->db->prepare("INSERT into usuario 
                    (usuario_id, login, nombre, apellidos, password, fecha_nacimiento, email_usuario, telef_usuario, dni, rol, afiliacion, nombre_puesto, nivel_jerarquia, depart_usuario, grupo_usuario, centro_usuario) 
					VALUES
					(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            if( $stmt->execute(array(null, $this->login, $this->nombre, $this->apellidos, $this->password, $this->fecha_nacimiento, $this->email_usuario,
                $this->telef_usuario, $this->dni, $this->rol, $this->afiliacion, $this->nombre_puesto, $this->nivel_jerarquia, $this->depart_usuario, $this->grupo_usuario, $this->centro_usuario))){
                return true;
            }else{
                return "Error insertando el usuario";
            }


		}

        //Devuelve un array de USUARIOs con todos los usuarios de la tabla.
        function SHOWALL(){
            $stmt = $this->db->prepare("SELECT * FROM usuario");
            $stmt->execute();
            $users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allUsers = array();  //array para almacenar los datos de todos los usuarios

            //Recorremos todos las filas de usuario devueltas por la sentencia sql
            foreach ($users_db as $user){
                //Introducimos uno a uno los usuarios recuperados de la BD
                array_push($allUsers,
                            new USUARIO_Model(
                                $user['usuario_id'],$user['login'],$user['nombre']
                                ,$user['apellidos'],$user['password'],$user['fecha_nacimiento'],$user['email_usuario']
                                ,$user['telef_usuario'],$user['dni'],$user['rol'],$user['afiliacion'],$user['nombre_puesto']
                                ,$user['nivel_jerarquia'],$user['depart_usuario'],$user['grupo_usuario'],$user['centro_usuario']
                            )
                );
            }
            return $allUsers;
        }

        function devolverUsuariosNivelJerarquia($nivel){
            $stmt = $this->db->prepare("SELECT * FROM usuario WHERE nivel_jerarquia = ?");
            $stmt->execute(array($nivel));
            $users_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $allUsers = array();


            foreach ($users_db as $user){

                array_push($allUsers,
                    new USUARIO_Model(
                        $user['usuario_id'],$user['login'],$user['nombre']
                        ,$user['apellidos'],$user['password'],$user['fecha_nacimiento'],$user['email_usuario']
                        ,$user['telef_usuario'],$user['dni'],$user['rol'],$user['afiliacion'],$user['nombre_puesto']
                        ,$user['nivel_jerarquia'],$user['depart_usuario'],$user['grupo_usuario'],$user['centro_usuario']
                    )
                );
            }
            return $allUsers;
        }

		function generarLogin(){
			$surname = explode(" ", $this->apellidos);

			$resultado_login = $this->nombre[0];
			$resultado_login .= $surname[0][0];
			$resultado_login .= $surname[1];

			$login_number = 0;

			while(true){

                $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ?");

                $stmt->execute(array($resultado_login));

                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                if($resultado != null){
                    $resultado_login = str_replace($login_number,"",$resultado_login);
                    $login_number = $login_number + 1;
                    $resultado_login .= $login_number;
                }else{
                    return $resultado_login;
                }


			}

		}
		
		//Devuelte true si existe en la BD el login del objeto
		function existLogin(){
            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ?");
            $stmt->execute(array($this->login));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if($resultado != null){
                return true;
            }else{
                return "El usuario con este login ya existe";
            }
		}
		
		//Devuelte true si existe un usuario con el DNI del objeto
		function existDNI(){
            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE dni = ?");
            $stmt->execute(array($this->dni));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if($resultado != false){
                return true;
            }
			
		}
		
		//Verifica que el usuario existe y la contraseña asociada es correcta.
		function login(){
            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ? AND password = ? ");
            $stmt->execute(array($this->login, $this->password));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);    //Fetch para cuando esperamso SOLO UN resultado

            if($resultado != null){
                return true;
            }else{
                return "El usuario o la contraseña para este usuario no son correctos";
            }

		}

		function devolverDistintosNivelesJerarquia(){
            $stmt = $this->db->prepare("SELECT DISTINCT nivel_jerarquia
					FROM usuario
					WHERE nivel_jerarquia IS NOT NULL");

            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        }


        //Recupera los datos de un usuario a partir de su login
        function rellenaDatos(){
            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ?");

            $stmt->execute(array($this->login));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->usuario_id = $resultado["usuario_id"];
            $this->login = $resultado["login"];
            $this->nombre = $resultado["nombre"];
            $this->apellidos = $resultado["apellidos"];
            $this->password = $resultado["password"];
            $this->fecha_nacimiento = $resultado["fecha_nacimiento"];
            $this->email_usuario = $resultado["email_usuario"];
            $this->telef_usuario = $resultado["telef_usuario"];
            $this->dni = $resultado["dni"];
            $this->rol = $resultado["rol"];
            $this->afiliacion = $resultado["afiliacion"];
            $this->nombre_puesto = $resultado["nombre_puesto"];
            $this->nivel_jerarquia = $resultado["nivel_jerarquia"];
            $this->depart_usuario = $resultado["depart_usuario"];
            $this->grupo_usuario = $resultado["grupo_usuario"];
            $this->centro_usuario = $resultado["centro_usuario"];

            return $resultado;
        }

        //Recupera el rol de un usuario determinado
        //Devuelve el rol del usuario si lo encuentra en la BD, mensaje de error en caso contrario
        function consultarRol(){

            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ? ");
            $stmt->execute(array($this->login));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if($resultado != null){
                return $resultado['rol'];
            }else{
                return 'No existe el usuario en la BD';
            }
        }

		
		//Elimina un USUARIO
		function DELETE(){

            $stmt = $this->db->prepare("DELETE
					FROM usuario
					WHERE login = ? ");

            if( $stmt->execute(array($this->login))){
                return true;
            }else{
                return "Error eliminando el usuario";
            }
        }

        //Recupera el id de un usuario determinado
        //Devuelve el id del usuario si lo encuentra en la BD, mensaje de error en caso contrario
        function consultarId(){

            $stmt = $this->db->prepare("SELECT *
					FROM usuario
					WHERE login = ? ");
            $stmt->execute(array($this->login));
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if($resultado != null){
                return $resultado['usuario_id'];
            }else{
                return 'No existe el usuario en la BD';
            }
        }


        //----------------------------FUNCIONES SIN SQL---------------------------------------------
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
        public function getLogin()
        {
            return $this->login;
        }

        /**
         * @param mixed $login
         */
        public function setLogin($login)
        {
            $this->login = $login;
        }

        /**
         * @return mixed
         */
        public function getNombre()
        {
            return $this->nombre;
        }

        /**
         * @param mixed $nombre
         */
        public function setNombre($nombre)
        {
            $this->nombre = $nombre;
        }

        /**
         * @return mixed
         */
        public function getApellidos()
        {
            return $this->apellidos;
        }

        /**
         * @param mixed $apellidos
         */
        public function setApellidos($apellidos)
        {
            $this->apellidos = $apellidos;
        }

        /**
         * @return mixed
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param mixed $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }

        /**
         * @return mixed
         */
        public function getFechaNacimiento()
        {
            return $this->fecha_nacimiento;
        }

        /**
         * @param mixed $fecha_nacimiento
         */
        public function setFechaNacimiento($fecha_nacimiento)
        {
            $this->fecha_nacimiento = $fecha_nacimiento;
        }

        /**
         * @return mixed
         */
        public function getEmailUsuario()
        {
            return $this->email_usuario;
        }

        /**
         * @param mixed $email_usuario
         */
        public function setEmailUsuario($email_usuario)
        {
            $this->email_usuario = $email_usuario;
        }

        /**
         * @return mixed
         */
        public function getTelefUsuario()
        {
            return $this->telef_usuario;
        }

        /**
         * @param mixed $telef_usuario
         */
        public function setTelefUsuario($telef_usuario)
        {
            $this->telef_usuario = $telef_usuario;
        }

        /**
         * @return mixed
         */
        public function getDni()
        {
            return $this->dni;
        }

        /**
         * @param mixed $dni
         */
        public function setDni($dni)
        {
            $this->dni = $dni;
        }

        /**
         * @return mixed
         */
        public function getRol()
        {
            return $this->rol;
        }

        /**
         * @param mixed $rol
         */
        public function setRol($rol)
        {
            $this->rol = $rol;
        }

        /**
         * @return mixed
         */
        public function getAfiliacion()
        {
            return $this->afiliacion;
        }

        /**
         * @param mixed $afiliacion
         */
        public function setAfiliacion($afiliacion)
        {
            $this->afiliacion = $afiliacion;
        }

        /**
         * @return mixed
         */
        public function getNombrePuesto()
        {
            return $this->nombre_puesto;
        }

        /**
         * @param mixed $nombre_puesto
         */
        public function setNombrePuesto($nombre_puesto)
        {
            $this->nombre_puesto = $nombre_puesto;
        }

        /**
         * @return mixed
         */
        public function getNivelJerarquia()
        {
            return $this->nivel_jerarquia;
        }

        /**
         * @param mixed $nivel_jerarquia
         */
        public function setNivelJerarquia($nivel_jerarquia)
        {
            $this->nivel_jerarquia = $nivel_jerarquia;
        }

        /**
         * @return mixed
         */
        public function getDepartUsuario()
        {
            return $this->depart_usuario;
        }

        /**
         * @param mixed $depart_usuario
         */
        public function setDepartUsuario($depart_usuario)
        {
            $this->depart_usuario = $depart_usuario;
        }

        /**
         * @return mixed
         */
        public function getGrupoUsuario()
        {
            return $this->grupo_usuario;
        }

        /**
         * @param mixed $grupo_usuario
         */
        public function setGrupoUsuario($grupo_usuario)
        {
            $this->grupo_usuario = $grupo_usuario;
        }

        /**
         * @return mixed
         */
        public function getCentroUsuario()
        {
            return $this->centro_usuario;
        }

        /**
         * @param mixed $centro_usuario
         */
        public function setCentroUsuario($centro_usuario)
        {
            $this->centro_usuario = $centro_usuario;
        }

    }


?>