<?php
	
	class USUARIO_Model{
		
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
		var $mysqli;
		
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
			include_once 'Access_DB.php';
			$this->mysqli = ConnectDB();
		}


		//Realiza un ADD sobre la tabla USUARIO. Devuelve un mensaje informando del resultado.
		function registrar(){
			
			$this->login = $this->generarLogin();
			
			//Comprueba si existe un usuario con el DNI especificado
			if($this->existeDNI()){
				return "Ya existe el DNI";
			}
			
			$sql = "insert into usuario (
							usuario_id,
							login,
							nombre,
							apellidos,
							password,
							fecha_nacimiento,
							email_usuario,
							telef_usuario,
							dni,
							rol,
							afiliacion,
							nombre_puesto,
							nivel_jerarquia,
							depart_usuario,
							grupo_usuario,
							centro_usuario) 
								VALUES (
									null,
									'".$this->login."',
									'".$this->nombre."',
									'".$this->apellidos."',
									'".$this->password."',
									'".$this->fecha_nacimiento."',
									'".$this->email_usuario."',
									'".$this->telef_usuario."',
									'".$this->dni."',
									'".$this->rol."',
									'".$this->afiliacion."',
									'".$this->nombre_puesto."',
									'".$this->nivel_jerarquia."',
									'".$this->depart_usuario."',
									'".$this->grupo_usuario."',
									'".$this->centro_usuario."'
									);";
			
			
			if (!$this->mysqli->query($sql)) {
				return 'Error en el registro';//Si se produce algún error durante la inserción.
			}
			else{
				return 'Registro realizado con éxito';//Inserción correcta
			}		
			
		}

        //Devuelve un array de USUARIOs con todos los usuarios de la tabla.
        function SHOWALL(){

            $sql = "SELECT * FROM usuario";

            $resultado = $this->mysqli->query($sql); //Guarda el resultado de la consulta.

            $usuarios = $resultado->fetch_All(MYSQLI_ASSOC);
            $usuarios_toret = array();

            foreach($usuarios as $usuario){ //Par cada tupla recuperada
                array_push($usuarios_toret, new USUARIO_Model($usuario['usuario_id'],
                    $usuario['login'],
                    $usuario['nombre'],
                    $usuario['apellidos'],
                    $usuario['password'],
                    $usuario['fecha_nacimiento'],
                    $usuario['email_usuario'],
                    $usuario['telef_usuario'],
                    $usuario['dni'],
                    $usuario['rol'],
                    $usuario['afiliacion'],
                    $usuario['nombre_puesto'],
                    $usuario['nivel_jerarquia'],
                    $usuario['depart_usuario'],
                    $usuario['grupo_usuario'],
                    $usuario['depart_usuario']
                )); //Crea un usuario con los datos recuperados por la consulta y lo almacena en el array
            }


            return $usuarios_toret;

        }

		function generarLogin(){
			$surname = explode(" ", $this->apellidos);

			$resultado_login = $this->nombre[0];
			$resultado_login .= $surname[0][0];
			$resultado_login .= $surname[1];

			$login_number = 0;

			while(true){
				$sql = "SELECT * FROM usuario WHERE login = '".$resultado_login."';";
				
				$resultado = $this->mysqli->query($sql);

				if($resultado->num_rows <= 0) {
					return $resultado_login;
				}
				else{
					$login_number = $login_number + 1;

					$resultado_login .= $login_number;
				}
			}

		}
		
		//Devuelte true si existe en la BD el login del objeto
		function existeLogin(){
			$sql = "SELECT * FROM usuario WHERE login = '".$this->login."';";
			
			$resultado = $this->mysqli->query($sql);	
			
			return ($resultado->num_rows > 0); //Devuelve true si la consulta SQL devolvió alguna tupla
		}
		
		//Devuelte true si existe un usuario con el DNI del objeto
		function existeDNI(){
			$sql = "SELECT * FROM usuario WHERE dni = '".$this->dni."';";
			
			$resultado = $this->mysqli->query($sql);
			
			return ($resultado->num_rows > 0); //Devuelve true si la consulta SQL devolvió alguna tupla
			
		}
		
		//Verifica que el usuario existe y la contraseña asociada es correcta.
		function login(){

			$sql = "SELECT *
					FROM usuario
					WHERE login = '".$this->login."'";
		
			$resultado = $this->mysqli->query($sql);
			if ($resultado->num_rows == 0){ //Comprueba si existe el login
				return 'El login no existe';
			}
			else{
				$tupla = $resultado->fetch_array();
				if ($tupla['password'] == $this->password){ //Si existe el login, comprueba si la contraseña es correcta
					return 'true';
				}
				else{
					return 'La password para este usuario no es correcta';
				}
			}
		}
		


        //Recupera los datos de un usuario a partir de su login
        function rellenaDatos(){
            $sql="SELECT * FROM usuario WHERE (`login` LIKE '".$this->login."')";
            $resultado=$this->mysqli->query($sql);
            $registro=mysqli_fetch_array($resultado);

            $this->usuario_id = $registro["usuario_id"];
            $this->login = $registro["login"];
            $this->nombre = $registro["nombre"];
            $this->apellidos = $registro["apellidos"];
            $this->password = $registro["password"];
            $this->fecha_nacimiento = $registro["fecha_nacimiento"];
            $this->email_usuario = $registro["email_usuario"];
            $this->telef_usuario = $registro["telef_usuario"];
            $this->dni = $registro["dni"];
            $this->rol = $registro["rol"];
            $this->afiliacion = $registro["afiliacion"];
            $this->nombre_puesto = $registro["nombre_puesto"];
            $this->nivel_jerarquia = $registro["nivel_jerarquia"];
            $this->depart_usuario = $registro["depart_usuario"];
            $this->grupo_usuario = $registro["grupo_usuario"];
            $this->centro_usuario = $registro["centro_usuario"];

            return $registro;
        }

        //Recupera el rol de un usuario determinado
        //Devuelve el rol del usuario si lo encuentra en la BD, mensaje de error en caso contrario
        function getRol(){
            $sql = "SELECT * FROM usuario WHERE(`login` = '". $this->login ."')";
            $result = $this->mysqli->query($sql);

            if($result->num_rows == 1){
                $tuple = $result->fetch_array();
                return $tuple['rol'];
            }else{
                return 'No existe el usuario en la BD';
            }
        }

		
		//Elimina un USUARIO
		function DELETE(){
		    var_dump($this->login);
			$sql = "DELETE FROM usuario
                    WHERE login = '".$this->login."'";

            if(!$this->mysqli->query($sql)){
                var_dump($sql);
                return "Error eliminando el usuario"; //Se produce un error al eliminar el usuario
            }
            else{
                var_dump($sql);
                return "Usuario eliminado"; //Se elimina correctamente el usuario
            }
        }

    }
?>