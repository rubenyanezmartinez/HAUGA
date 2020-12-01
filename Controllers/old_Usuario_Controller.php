
<?php

	session_start(); //solicito trabajar con la session
	include '../Functions/Authentication.php';//incluye el fichero Authentication.php
	//include '../Views/MESSAGE_View.php';//incluye el fichero MESSAGE_View.php
	include "../Models/USUARIO_Model.php";//incluye el fichero USUARIO_Model.php
	
	function valores_form(){
		
		$login = $_REQUEST['login'];
		$password = $_REQUEST['password'];
		$dni = $_REQUEST['dni'];
		$apellidos = $_REQUEST['apellidos'];
		$nombre = $_REQUEST['nombre'];
		$telefono = $_REQUEST['telefono'];
		//Comprueba si se ha subido un fichero (importante para el EDIT)
		if(array_key_exists('avatar', $_FILES) && $_FILES['avatar']['name']!=''){
			$avatar = "../Files/" . $_FILES['avatar']['name'];
		} else if(isset($_REQUEST['avatar'])){
			$avatar = "../Files/" . $_REQUEST['avatar'];
		} else {
			$avatar = '';
		}
		
		if(isset($_REQUEST['fechaNacimiento']) && $_REQUEST['fechaNacimiento'] != ''){
			//Reformatear la fecha para que la acepte la BD---
			$fechaPOST = preg_split("/\//", $_REQUEST['fechaNacimiento']);
			$fechaNacimiento = $fechaPOST[2]."-".$fechaPOST[1]."-".$fechaPOST[0];
			//-----
		} else {
			$fechaNacimiento = '';
		}
		
		if(isset($_REQUEST['pujador'])){
			$pujador = $_REQUEST['pujador'];
		} else {
			//Si el campo pujador no está rellenado, le asigna una cadena vacía.
			$pujador = 'no';
		}
		
		if(isset($_REQUEST['subastador'])){
			$subastador = $_REQUEST['subastador'];
		} else {
			//Si el campo subastadir no está rellenado, le asigna una cadena vacía.			
			$subastador = 'no';
		}
		
		if(isset($_REQUEST['administrador'])){
			$administrador = $_REQUEST['pujador'];
		} else {
			//Si el campo administrador no está rellenado, le asigna una cadena vacía.
			$administrador = 'no';
		}
		
		
		$usuario = new USUARIO_Model($login,$password,$dni,$apellidos,$nombre,$telefono,$avatar,$fechaNacimiento,$pujador,$subastador,$administrador);
		
		return $usuario;
	}
	
	//Recoge los valores de un formulario LOGIN
	function valores_form_login(){
		
		$login = $_REQUEST['login'];
		$password = $_REQUEST['password'];
		
		$usuario = new USUARIO_Model($login,$password,'','','','','','','','','');
		
		return $usuario;
	}

    //Recoge los valores de un formulario ADD
    function valores_form_add(){

        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $password = $_POST['password'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $email_usuario = $_POST['email_usuario'];
        $telef_usuario = $_POST['telef_usuario'];
        $dni = $_POST['dni'];
        $rol = $_POST['rol'];
        $afiliacion = $_POST['afiliacion'];
        $nombre_puesto='';
        if(isset($_POST['nombre_puesto'])){
            $nombre_puesto = $_POST['nombre_puesto'];
        }
        $nivel_jerarquia = '';
        if(isset($_POST['nivel_jerarquia'])){
            $nivel_jerarquia = $_POST['nivel_jerarquia'];
        }
        $depart_usuario = '';
        if(isset($_POST['depart_usuario'])){
            $depart_usuario = $_POST['depart_usuario'];
        }
        $grupo_usuario = '';
        if(isset($_POST['grupo_usuario'])){
            $grupo_usuario = $_POST['grupo_usuario'];
        }
        $centro_usuario = '';
        if(isset($_POST['centro_usuario'])){
            $centro_usuario = $_POST['centro_usuario'];
        }

        $usuario = new USUARIO_Model('','', $nombre, $apellidos, $password, $fecha_nacimiento,$email_usuario,$telef_usuario,$dni,$rol,$afiliacion,$nombre_puesto,$nivel_jerarquia,$depart_usuario, $grupo_usuario, $centro_usuario);

        return $usuario;
    }
	
	if(isset($_REQUEST['action'])){//Si existe una accion mediante post se almacena en una variable
		$accion=$_REQUEST['action'];
	} else if(isset($_GET['action'])){//Si existe una accion mediante post se almacena en una variable
		$accion=$_GET['action'];
	} else {//Si no existe ninguna de las anteriores la variable estará vacía e irá al default del switch
		$accion = '';
	}
	
	Switch($accion){
		case 'EDIT':
			//Comprueba si se ha rellenado un formulario
			if(!$_POST){
				//Crea un USUARIO con los datos de la tupla seleccionada.
				$usuario=new USUARIO_Model($_REQUEST['login'],'','','','','','','','','','');
				$usuario->RellenaDatos();
				$fechaPOST = preg_split("/-/", $usuario->fechaNacimiento);
				$usuario->fechaNacimiento = $fechaPOST[2]."/".$fechaPOST[1]."/".$fechaPOST[0];
				//Llama a la vista
				include '../Views/USUARIO_EDIT_View.php';
				new USUARIO_EDIT_View($usuario);
			} else {
				//Comprueba si se ha subido un nuevo fichero
				if(isset($_FILES['avatar']) && $_FILES['avatar']['name']!=''){
					//Si es así, elimina el avatar anterior.
					$usuario=new USUARIO_Model($_REQUEST['email'],'','','','','','','','','','');
					$usuario->RellenaDatos();
					$ruta='../Files/'.$usuario->avatar; 
					unlink($ruta);
				}
				
				$usuario = valores_form();
				$uploadOk = 1;
				
				if(isset($_FILES['avatar']) && $_FILES['avatar']['name']!=''){
					
					//Guarda el nuevo fichero resguardo.
					$target_dir = "../Files/";
					$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					
					if (file_exists($target_file)) {
						new MESSAGE ("El fichero avatar ya existe.",  './Index_Controller.php');
						$uploadOk = 0;
					}
					
					// Comprueba si el fichero es una imagen o un pdf
					if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "pdf" ) {
						new MESSAGE ("Formato del fichero avatar incorrecto.", './Usuario_Controller.php');
						$uploadOk = 0;
					}
					
					// Si todo está en orden, sube el fichero al servidor.
					if ($uploadOk == 1) {
						move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
					}
				} 
				
				// Si no ha habido ningún problema, edita la tupla en la base de datos.
				if($uploadOk == 1){
					$respuesta=$usuario->EDIT();
					new MESSAGE($respuesta, '../index.php');
				}
			}
			
			break;
		case 'ADD'://Caso ADD realiza el registro de un usuario
			if(!$_POST){//Antes de cubrir el formulario
				include '../Views/USUARIO_ADD_View.php';
				new USUARIO_ADD_View();
			} else {
				$usuario = valores_form_add(); //USUARIO con los datos introducidos en el formulario.
                var_dump(($usuario->registrar()));
			}
			
			break;
		case 'SEARCH': //Caso SEARCH, permite buscar un usuario por los campos que se desee
			if(!$_POST){//Antes de cubrir el formulario búsqueda
				include '../Views/USUARIO_SEARCH_View.php';
				new USUARIO_SEARCH_View();//Muestra el formulario
			} else {
				$usuario = valores_form();//Crea un usuario con los valores introducidos en el formulario
				$arrayUsuarios = $usuario->SEARCH();
				
				if(count($arrayUsuarios) == 0){//Si la búsqueda no devuelve ningún usuario
					new MESSAGE('No se han encontrado coincidencias', '../Controllers/Usuario_Controller.php?action=SEARCH');
				} else {
					//Si encuentra usuarios, muestr una tabla showall con los resultados
					include '../Views/USUARIO_SHOWALL_View.php';
					new USUARIO_SHOWALL_View($arrayUsuarios);
				}
			}
			
			break;
		case 'DELETE'://Caso DELETE borra un usuario
			if($_GET){//Antes de confirmar el borrado
                $usuario = new USUARIO_Model('',$_GET['login'],'','','','','','','','','', '', '', '', '', ''); //Crea un usuario con el login
                var_dump($usuario->DELETE()); //Elimina el usuario
			}
			break;
		case 'SHOWCURRENT'://Muestra los detalles de un usuario
			if(isset($_REQUEST['login'])){
				$loginUser = $_REQUEST['login'];
			} else {
				$loginUser = $_SESSION['login'];
			}
			
			$userShowcurrent = new USUARIO_Model($loginUser,'','','','','','','','','','');
			$userShowcurrent->RellenaDatos();
			$fechaPOST = preg_split("/-/", $userShowcurrent->fechaNacimiento);
			$userShowcurrent->fechaNacimiento = $fechaPOST[2]."/".$fechaPOST[1]."/".$fechaPOST[0];
			include '../Views/USUARIO_SHOWCURRENT_View.php';
			new USUARIO_SHOWCURRENT_View($userShowcurrent);
			
			break;
		
		case 'LOGIN'://Realiza el LOGIN de un usuario
			if(!$_POST){//Antes de cubrir el formulario LOGIN
				include '../Views/LOGIN_View.php';
				new LOGIN_View();//Muestra el formulario LOGIN
			} else {
				$usuario = valores_form_login();//Recupera los valores del formulario
				$respuesta = $usuario->login();//Llama a la función del modelo que gestiona el login
				if ($respuesta == 'true'){ //Si el login es correcto
					session_start();//Inicia sesion y asigna el login
					$_SESSION['login'] = $_REQUEST['login'];
					header('Location:../index.php');
				}
				else{
				//Si el login se produce de forma incorrecta, muestra el mensaje de error.
					new MESSAGE($respuesta, '../Controllers/Usuario_Controller.php?action=LOGIN');
				}
			}
			
			break;
			
		default: //Caso por defecto, muestra todos los usuarios.
			$usuario = new USUARIO_Model('','','','','','','','','','',''); //Crea un USUARIO vacío
			$AllUsuarios = $usuario->SHOWALL(); //En $AllUsuarios se guarda el array de USUARIOs que devuelte el SHOWALL con todos los USUARIOs registrados
			include '../Views/USUARIO_SHOWALL_View.php'; //Incluye el fichero php con la vista del SHOWALL
			new USUARIO_SHOWALL_View($AllUsuarios); //Llama al constructor de Usuario_Showall, que muestra la tabla.
			break;
	}

?>