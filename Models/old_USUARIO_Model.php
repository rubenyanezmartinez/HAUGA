<?php
	
	class old_USUARIO_Model{
		
		var $login;
		var $password;
		var $dni;
		var $apellidos;
		var $nombre;
		var $telefono;
		var $avatar;
		var $fechaNacimiento;
		var $pujador;
		var $subastador;
		var $administrador;
		var $mysqli;
		
		//Crea un objeto USUARIO
		function __construct($login,
							 $password,
							 $dni,
							 $apellidos,
							 $nombre,
							 $telefono,
							 $avatar,
							 $fechaNacimiento,
							 $pujador,
							 $subastador,
							 $administrador){
			$this->login = $login;
			$this->password = $password;
			$this->dni = $dni;
			$this->apellidos = $apellidos;
			$this->nombre = $nombre;
			$this->telefono = $telefono;
			$this->avatar = $avatar;
			$this->fechaNacimiento =  $fechaNacimiento;
			$this->pujador = $pujador;
			$this->subastador = $subastador;
			$this->administrador = $administrador;
			include_once 'Access_DB.php';
			$this->mysqli = ConnectDB();
		}
		
		//A partir del login, rellena los demás datos del objeto
		function RellenaDatos()
		{
			
			$sql="SELECT * FROM USUARIO WHERE login LIKE '".$this->login."'";
			$resultado=$this->mysqli->query($sql);
			$registro=mysqli_fetch_array($resultado);
			
			$this->login = $registro[0];
			$this->password = $registro[1];
			$this->dni = $registro[2];
			$this->nombre = $registro[3];
			$this->apellidos = $registro[4];
			$this->telefono = $registro[5];
			$this->fechaNacimiento = $registro[7];
			$this->avatar = $registro[6];
			$this->pujador = $registro[8];
			$this->subastador = $registro[9];
			$this->administrador = $registro[10];
			
			return $registro;
		
		}
		
		//Realiza un ADD sobre la tabla USUARIO. Devuelve un mensaje informando del resultado.
		function registrar(){
			
			//Comprueba si existe el login
			if($this->existeLogin()){
				return "Ya existe el login";
			}
			
			//Comprueba si existe un usuario con el DNI especificado
			if($this->existeDNI()){
				return "Ya existe el DNI";
			}
			
			$sql = "INSERT INTO USUARIO (
							login,
							password,
							dni,
							apellidos,
							nombre,
							telefono,
							avatar,
							fechaNacimiento,
							pujador,
							subastador,
							administrador) 
								VALUES (
									'".$this->login."',
									'".$this->password."',
									'".$this->dni."',
									'".$this->apellidos."',
									'".$this->nombre."',
									'".$this->telefono."',
									'".$this->avatar."',
									'".$this->fechaNacimiento."',
									'".$this->pujador."',
									'".$this->subastador."',
									'".$this->administrador."'
									)";
			
			
			if (!$this->mysqli->query($sql)) {
				return 'Error en el registro';//Si se produce algún error durante la inserción.
			}
			else{
				return 'Registro realizado con éxito';//Inserción correcta
			}		
			
		}
		
		//Devuelte true si existe en la BD el login del objeto
		function existeLogin(){
			$sql = "SELECT * FROM USUARIO WHERE login = '".$this->login."';";
			
			$resultado = $this->mysqli->query($sql);	
			
			return ($resultado->num_rows > 0); //Devuelve true si la consulta SQL devolvió alguna tupla
		}
		
		//Devuelte true si existe un usuario con el DNI del objeto
		function existeDNI(){
			$sql = "SELECT * FROM USUARIO WHERE DNI = '".$this->dni."';";
			
			$resultado = $this->mysqli->query($sql);
			
			return ($resultado->num_rows > 0); //Devuelve true si la consulta SQL devolvió alguna tupla
			
		}
		
		//Verifica que el usuario existe y la contraseña asociada es correcta.
		function login(){

			$sql = "SELECT *
					FROM USUARIO
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
		
		//Devuelve un array de USUARIOs con todos los usuarios de la tabla.
		function SHOWALL(){
		
			$sql = "SELECT * FROM USUARIO";
			
			$resultado = $this->mysqli->query($sql); //Guarda el resultado de la consulta.

            $usuarios = $resultado->fetch_All(MYSQLI_ASSOC); 
            $usuarios_toret = array();

            foreach($usuarios as $usuario){ //Par cada tupla recuperada
                array_push($usuarios_toret, new USUARIO_Model($usuario['login'],
                                                        $usuario['password'],
                                                        $usuario['dni'],
                                                        $usuario['apellidos'],
                                                        $usuario['nombre'],
                                                        $usuario['telefono'],
                                                        $usuario['avatar'],
                                                        $usuario['fechaNacimiento'],
														$usuario['pujador'],
														$usuario['subastador'],
														$usuario['administrador']
														)); //Crea un usuario con los datos recuperados por la consulta y lo almacena en el array
            }

            
            return $usuarios_toret;
		
		}
		
		//Edita un USUARIO
		function EDIT(){				
		
			$sql = "UPDATE USUARIO
                    SET password = '".$this->password."',
                    dni = '".$this->dni."',
                    apellidos = '".$this->apellidos."',
                    nombre = '".$this->nombre."',
                    telefono = '".$this->telefono."',
                    avatar = '".$this->avatar."',
					fechaNacimiento = '".$this->fechaNacimiento."',
					pujador = '".$this->pujador."',
					subastador = '".$this->subastador."',
					administrador = '".$this->administrador."' 
                    WHERE login = '".$this->login."'";
			
			if(!$this->mysqli->query($sql)){
                return "Error editando el usuario"; //Se edita correctamente el usuario
            }
            else{
                return "Usuario editado";//Se produce un error al editar
            }

		
		}
		
		//Elimina un USUARIO
		function DELETE(){
		
			$sql = "DELETE FROM USUARIO
                    WHERE login = '".$this->login."'";

            if(!$this->mysqli->query($sql)){
                return "Error eliminando el usuario"; //Se produce un error al eliminar el usuario
            }
            else{
                return "Usuario eliminado"; //Se elimina correctamente el usuario
            }
		
		}
		
		//Busca USUARIOs, devuelve un array de USUARIOs
		function SEARCH(){
		
			$sql = "SELECT * FROM USUARIO WHERE
						login LIKE '%".$this->login."%' AND
						password LIKE '%".$this->password."%' AND
						dni LIKE '%".$this->dni."%' AND
						apellidos LIKE '%".$this->apellidos."%' AND
						nombre LIKE '%".$this->nombre."%' AND
						telefono LIKE '%".$this->telefono."%' AND
						avatar LIKE '%".$this->avatar."%' AND
						fechaNacimiento LIKE '%".$this->fechaNacimiento."%' AND
						pujador LIKE '%".$this->pujador."%' AND
						subastador LIKE '%".$this->subastador."%' AND
						administrador LIKE '%".$this->administrador."%'" ;
			
			//Una vez realiza la consulta, hace el mismo proceso empleado en el SHOWALL para generar el array de USUARIOs			
			$resultado = $this->mysqli->query($sql);
			
            $usuarios = $resultado->fetch_All(MYSQLI_ASSOC);
            $usuarios_toret = array();

            foreach($usuarios as $usuario){
                array_push($usuarios_toret, new USUARIO_Model($usuario['login'],
                                                        $usuario['password'],
                                                        $usuario['dni'],
                                                        $usuario['apellidos'],
                                                        $usuario['nombre'],
                                                        $usuario['telefono'],
                                                        $usuario['avatar'],
                                                        $usuario['fechaNacimiento'],
														$usuario['pujador'],
														$usuario['subastador'],
														$usuario['administrador']
														));
            }

            
            return $usuarios_toret;
		
		}
		
		
	}
?>