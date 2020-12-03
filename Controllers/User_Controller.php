<?php
include '../Views/LOGIN_View.php';
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
include '../Models/CENTRO_Model.php';
include '../Models/GRUPO_INVESTIGACION_Model.php';
include '../Models/DEPARTAMENTO_Models.php';
include '../Models/INCIDENCIA_Model.php';
session_start();


if(!IsAuthenticated()){
    login();
}else{
    if(!isset($_GET['action'])){
        $action = '';
    } else{
        $action = $_GET['action'];
    }

    switch($action){
        //Comprobar si esta autenticado y si tiene el rol necesario
        case 'jerarquia': jerarquia();
            break;
        case 'showall': showall();
            break;
        case 'logout': logout();
            break;
        case 'add': add();
            break;
        case 'showcurrent':
            $login_usuario = $_GET['login_usuario'];
            showcurrent($login_usuario);
            break;
        case 'delete':
            delete();
            break;
        //Caso default para vista de error generico
        default: echo('default del switch user_controller');
            break;
    }
}


function login(){


    if(!isset($_POST['login']) && !isset($_POST['password'])){    //Si no estan instanciadas login y password

        $login = new Login_view();  //Muestra vista de login
    } else{ //Si se recibieron el login y la password

        $usuario = new USUARIO_Model(null, $_POST['login'], "", "",$_POST['password'], ""
            ,"","","","","","",
            "","","","");
        $existLogin = $usuario->existLogin();

        if($existLogin === true){   //Si existe el login en la BD
            $respuesta = $usuario->login();

            if($respuesta === true){ //Si coincide la contraseña dada con la del usuario
                session_start();
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['rol'] = $usuario->consultarRol();

                header('Location:../index.php');
            }else{
                //Mostramos datos introducidos y mensaje de error de que no coincide la password
                $login = new LOGIN_View(["login" => $_POST['login'], "password" => $_POST['password'], "respuesta"=>$respuesta]);

            }
        }else{  //No existe el login en la BD y se devuelve mensaje
            //Mostramos mensaje de error de que no existe dicho usuario
            $login = new LOGIN_View(["login" => $_POST['login'], "password" => $_POST['password'], "respuesta" => $existLogin]);
        }


    }

}


function showall(){
    $usuario = new USUARIO_Model('','','','','','','','','','','','','','','','');  //Crea un USUARIO vacio
    $AllUsuarios = $usuario->SHOWALL(); //En $AllUsuarios se guarda el array de USUARIOs que devuelve el SHOWALL con todos los USUSARIOs registrados

    $vectorUsuarios = [];

    for ($i = 0; $i < count($AllUsuarios); $i++) {
        $vectorUsuarios[$i]["login"] = $AllUsuarios[$i]->login;
        $vectorUsuarios[$i]["nombre"] = $AllUsuarios[$i]->nombre;
        $vectorUsuarios[$i]["apellidos"] = $AllUsuarios[$i]->apellidos;
        $vectorUsuarios[$i]["dni"] = $AllUsuarios[$i]->dni;
        $vectorUsuarios[$i]["email_usuario"] = $AllUsuarios[$i]->email_usuario;
        $vectorUsuarios[$i]["rol"] = $AllUsuarios[$i]->rol;
        $vectorUsuarios[$i]["afiliacion"] = $AllUsuarios[$i]->afiliacion;

        if ($vectorUsuarios[$i]["rol"] == "ADMIN"){
            $vectorUsuarios[$i]["info_afiliacion"] = "-";
        }
        else if ($vectorUsuarios[$i]["afiliacion"] == "DOCENTE") {
            $centro_model = new CENTRO_Model($AllUsuarios[$i]->centro_usuario, '','');
            $centro = $centro_model->rellenaDatos();

            $departamento_model = new DEPARTAMENTO_Models($AllUsuarios[$i]->depart_usuario, '','','','','','','');
            $departamento = $departamento_model->rellenaDatos();

            $vectorUsuarios[$i]["info_afiliacion"] = $departamento["nombre_depart"].", ".$centro["nombre_centro"];
        }
        else if ($vectorUsuarios[$i]["afiliacion"] == "INVESTIGADOR"){
            $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($AllUsuarios[$i]->grupo_usuario, '','','','','','');
            $grupo = $grupo_investigacion_model->rellenaDatos();
            $vectorUsuarios[$i]["info_afiliacion"] = $grupo["nombre_grupo"];
        }
        else if ($vectorUsuarios[$i]["afiliacion"] == "ADMINISTRACION"){
            $vectorUsuarios[$i]["info_afiliacion"] = $AllUsuarios[$i]->nivel_jerarquia.", ".$AllUsuarios[$i]->nombre_puesto;
        }
        else{
            $vectorUsuarios[$i]["info_afiliacion"] = "-";
        }
    }

    include '../Views/USUARIO_SHOWALL_View.php';    //Incluye fichero php con la vista SHOWALL
    new USUARIO_SHOWALL_View($vectorUsuarios);//LLama al constructor de Usuario_Showall, que muestra la tabla
}

function add(){
    $grupo = new GRUPO_INVESTIGACION_Model('','','','','','','');  //Crea un GRUPO vacio
    $grupos = $grupo->SHOWALL(); //En $Array con todos los grupos
    $departamento = new DEPARTAMENTO_Models('','','','','','','', '');  //Crea un DEPARTAMENTO vacio
    $departamentos = $departamento->SHOWALL(); //En $Array con todos los departamento
    $centro = new CENTRO_Model('','','');  //Crea un centro vacio
    $centros = $centro->SHOWALL(); //En $Array con todos los centros
    include '../Views/USUARIO_ADD_View.php';
    if(!$_POST){//Antes de cubrir el formulario
        $datos = ["nombre" => '', "apellidos" => '', "password" => '', "fecha_nacimiento" => '',
            "email_usuario" => '', "telef_usuario" => '', "dni" => '', "rol" => '', "afiliacion" => '',
            "nombre_puesto" => '', "nivel_jerarquia" => '', "depart_usuario" => '', "grupo_usuario" => '', "centro_usuario" => '',"respuesta"=>''];
        new USUARIO_ADD_View($datos, $grupos, $departamentos, $centros);
    } else {

        if($_POST['nombre_puesto']==""){
            $nombre_puesto=null;
        }else{
            $nombre_puesto = $_POST['nombre_puesto'];
        }

        if($_POST['nivel_jerarquia']==""){
            $nivel_jerarquia = null;
        }else{
            $nivel_jerarquia = $_POST['nivel_jerarquia'];
        }

        if(!isset($_POST['depart_usuario'])){
            $depart_usuario = null;
        }else{
            $depart_usuario = $_POST['depart_usuario'];
        }

        if(!isset($_POST['grupo_usuario'])){
            $grupo_usuario = null;
        }else{
            $grupo_usuario = $_POST['grupo_usuario'];
        }

        if(!isset($_POST['centro_usuario'])){
            $centro_usuario =null;

        }else{
            $centro_usuario = $_POST['centro_usuario'];
        }

        $usuario = new USUARIO_Model(null, '', $_POST['nombre'], $_POST['apellidos'],$_POST['password'], $_POST['fecha_nacimiento']
            ,$_POST['email_usuario'],$_POST['telef_usuario'],$_POST['dni'],$_POST['rol'],$_POST['afiliacion'],$nombre_puesto,
            $nivel_jerarquia,$depart_usuario,$grupo_usuario,$centro_usuario);//USUARIO con los datos introducidos en el formulario.

        $respuesta = $usuario->registrar();
        if($respuesta === true){
            header('Location:../Controllers/User_Controller.php?action=showall');
        }else{
            //Mostramos datos introducidos y mensaje de error
            $login = new USUARIO_ADD_View(["nombre" => $_POST['nombre'], "apellidos" => $_POST['apellidos'], "password" => $_POST['password'], "fecha_nacimiento" => $_POST['fecha_nacimiento'],
                "email_usuario" => $_POST['email_usuario'], "telef_usuario" => $_POST['telef_usuario'], "dni" => $_POST['dni'], "rol" => $_POST['rol'], "afiliacion" => $_POST['afiliacion'],
                "nombre_puesto" => $nombre_puesto, "nivel_jerarquia" => $nivel_jerarquia, "depart_usuario" => $depart_usuario, "grupo_usuario" => $grupo_usuario, "centro_usuario" => $centro_usuario,"respuesta"=>$respuesta], $grupos, $departamentos, $centros);
        }
    }
}


function showcurrent($login_usuario)
{
    include '../Views/USUARIO_SHOWCURRENT_View.php';

    $usuario_model = new USUARIO_Model('',$login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $usuario = $usuario_model->rellenaDatos();

    $vectorUsuario = [];

    $vectorUsuario["login"] = $usuario["login"];
    $vectorUsuario["nombre"] = $usuario["nombre"];
    $vectorUsuario["apellidos"] = $usuario["apellidos"];
    $fecha = explode("-", $usuario["fecha_nacimiento"]);
    $vectorUsuario["fecha_nacimiento"] = $fecha[2]."/".$fecha[1]."/".$fecha[0];
    $vectorUsuario["dni"] = $usuario["dni"];
    $vectorUsuario["telef_usuario"] = $usuario["telef_usuario"];
    $vectorUsuario["email_usuario"] = $usuario["email_usuario"];
    $vectorUsuario["rol"] = $usuario["rol"];

    if ($vectorUsuario["rol"] == "USUARIO_NORMAL"){
        $vectorUsuario["rol"] = "Usuario Normal";
    }
    else if ($vectorUsuario["rol"] == "ADMIN"){
        $vectorUsuario["rol"] = "Administrador";
    }

    $vectorUsuario["afiliacion"] = $usuario["afiliacion"];


    if ($vectorUsuario["rol"] == "ADMIN") {
        $vectorUsuario["info_afiliacion"] = "-";

    }
    else if ($vectorUsuario["afiliacion"] == "DOCENTE") {
        $centro_model = new CENTRO_Model($usuario["centro_usuario"], '', '');
        $centro = $centro_model->rellenaDatos();

        $departamento_model = new DEPARTAMENTO_Models($usuario["depart_usuario"], '', '', '', '', '', '', '');
        $departamento = $departamento_model->rellenaDatos();

        $vectorUsuario["info_afiliacion"] = $departamento["nombre_depart"]. ", " .$centro["nombre_centro"];

    }
    else if ($vectorUsuario["afiliacion"] == "INVESTIGADOR") {
        $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($usuario["grupo_usuario"], '', '', '', '', '', '');
        $grupo = $grupo_investigacion_model->rellenaDatos();
        $vectorUsuario["info_afiliacion"] = $grupo["nombre_grupo"];

    }
    else if ($vectorUsuario["afiliacion"] == "ADMINISTRACION") {
        $vectorUsuario["info_afiliacion"] = $usuario["nivel_jerarquia"]. ", " .$usuario["nombre_puesto"];
    }
    else {
        $vectorUsuario["info_afiliacion"] = "-";
    }

    new USUARIO_SHOWCURRENT_View($vectorUsuario);

}

function logout(){
    logoutSession();   //De Desconectar.php
}

function delete(){
    if(isset($_GET['login_usuario'])){//Antes de confirmar el borrado
        $usuario = new USUARIO_Model('', $_GET['login_usuario'], '', '','', ''
            ,'','','','','','',
            '','', '','');
        $id_usuario = $usuario->consultarId();
        $grupo = new GRUPO_INVESTIGACION_Model('','','','','','',$id_usuario);  //Crea un GRUPO con responsable
        $grupo->actualizarResponsable(); //En $Array con todos los grupos
        $departamento = new DEPARTAMENTO_Models('','','','','','',$id_usuario, '');  //Crea un DEPARTAMENTO vacio
        $departamento -> actualizarResponsable();
        $incidencia = new INCIDENCIA_Model('','','','',$id_usuario);  //Crea un DEPARTAMENTO vacio
        $incidencia -> actualizarResponsable();
        $usuario = new USUARIO_Model('',$_GET['login_usuario'],'','','','','','','','','', '', '', '', '', ''); //Crea un usuario con el login
        $respuesta = $usuario->DELETE(); //Elimina el usuario
        if($respuesta === true){
            header('Location:../Controllers/User_Controller.php?action=showall');
        }
    }
}

function jerarquia(){
    include '../Views/USUARIO_JERARQUIA_View.php';

    //Recuerar todos los distintos niveless
    $usuario_model = new USUARIO_Model('','','','','','','','','','','','','','','','');
    $niveles = $usuario_model->devolverDistintosNivelesJerarquia();

    //Pasar los niveles a un array ordenado
    $vectorNiveles = [];
    foreach($niveles as $nivel){
        array_push($vectorNiveles, $nivel["nivel_jerarquia"]);
    }
    sort($vectorNiveles, SORT_NUMERIC);

    $toret = [];
    //Recorrer todos los niveles anotando a el puesto del nivel y el responsable
    foreach ($vectorNiveles as $nivel){
        $toret[$nivel] = $usuario_model->devolverUsuariosNivelJerarquia($nivel);
    }

    print_r($toret);

    new USUARIO_JERARQUIA_View();
}



?>