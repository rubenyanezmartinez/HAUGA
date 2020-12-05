<?php
include '../Views/LOGIN_View.php';
include '../Views/USUARIO_SHOWCURRENT_View.php';
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
include '../Models/CENTRO_Model.php';
include '../Models/GRUPO_INVESTIGACION_Model.php';
include '../Models/DEPARTAMENTO_Models.php';
include '../Models/INCIDENCIA_Model.php';
session_start();

const TAM_PAG = 5;

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
        case 'edit':
            if(!$_POST){
                $login_usuario = $_GET['login_usuario'];
                showcurrentEdit($login_usuario);
            }else{
                if($_SESSION['rol']=='ADMIN'){
                    $login_usuario = $_GET['login_usuario'];
                }else{
                    $login_usuario = $_SESSION['login'];
                }
                edit($login_usuario);
            }
            break;
        case 'jerarquia': jerarquia();
            break;
        case 'showall':
            if (!isset($_GET['numero_pagina'])) { $numero_pagina = 1; }
            else { $numero_pagina = $_GET['numero_pagina']; }
            showall($numero_pagina);
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


function showall($numero_pagina){
    $usuario = new USUARIO_Model('','','','','','','','','','','','','','','','');  //Crea un USUARIO vacio
    $AllUsuarios = $usuario->SHOWALL(); //En $AllUsuarios se guarda el array de USUARIOs que devuelve el SHOWALL con todos los USUSARIOs registrados

    //Paginación
    $numero_usuarios = count($AllUsuarios);
    $num_paginas_posibles = ceil($numero_usuarios/5);
    if ($numero_pagina > $num_paginas_posibles or $numero_pagina <= 0) {
        $numero_pagina = 1;
    }
    if ($numero_pagina == 1){
        $inicioUsuarios = 0;
    }
    else{
        $inicioUsuarios = (($numero_pagina-1)*TAM_PAG);
    }
    $finalUsuarios = $inicioUsuarios+TAM_PAG;
    if($finalUsuarios > $numero_usuarios){
        $finalUsuarios = $numero_usuarios;
    }


    $info_afiliacion = [];

    for ($i = $inicioUsuarios; $i < $finalUsuarios; $i++) {

        if ($AllUsuarios[$i]->getAfiliacion() == "DOCENTE") {

            $centro_model = new CENTRO_Model($AllUsuarios[$i]->centro_usuario, '', '');
            $centro = $centro_model->rellenaDatos();

            $departamento_model = new DEPARTAMENTO_Models($AllUsuarios[$i]->depart_usuario, '', '', '', '', '', '', '');
            $departamento = $departamento_model->rellenaDatos();

            $info_afiliacion[$i] = $departamento->getNombreDepartamento() . ", " . $centro->getNombreCentro();

        }
        else if ($AllUsuarios[$i]->getAfiliacion() == "INVESTIGADOR") {

            $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($AllUsuarios[$i]->grupo_usuario, '', '', '', '', '', '');
            $grupo = $grupo_investigacion_model->rellenaDatos();

            $info_afiliacion[$i] = $grupo->getNombreGrupo();

        }
        else if ($AllUsuarios[$i]->getAfiliacion() == "ADMINISTRACION") {

            $info_afiliacion[$i] = $AllUsuarios[$i]->nivel_jerarquia . ", " . $AllUsuarios[$i]->nombre_puesto;

        }
        else {
            $info_afiliacion[$i] = "-";
        }

    }

    include '../Views/USUARIO_SHOWALL_View.php';    //Incluye fichero php con la vista SHOWALL
    new USUARIO_SHOWALL_View($AllUsuarios, $info_afiliacion, $inicioUsuarios, $finalUsuarios, $num_paginas_posibles);//LLama al constructor de Usuario_Showall, que muestra la tabla
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
    $esModificar = false;    //Indica a la vista que se van a poder editar datos

    $usuario_model = new USUARIO_Model('',$login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $usuario = $usuario_model->rellenaDatos();

    if ($usuario == 'Error inesperado al intentar cumplir su solicitud de consulta'){
        new USUARIO_SHOWCURRENT_View(null, null, null);
    }
    else{
        $fecha = explode("-", $usuario->getFechaNacimiento());
        $usuario->setFechaNacimiento($fecha[2]."/".$fecha[1]."/".$fecha[0]);

        if ($usuario->getRol() == "USUARIO_NORMAL"){
            $usuario->setRol("Usuario Normal");
        }
        else if ($usuario->getRol() == "ADMIN"){
            $usuario->setRol("Administrador");
        }

        if ($usuario->getAfiliacion() == "DOCENTE") {
            $centro_model = new CENTRO_Model($usuario->getCentroUsuario(), '', '');
            $centro = $centro_model->rellenaDatos();

            $departamento_model = new DEPARTAMENTO_Models($usuario->getDepartUsuario(), '', '', '', '', '', '', '');
            $departamento = $departamento_model->rellenaDatos();

            $info_afiliacion = $departamento->getNombreDepartamento(). ", " . $centro->getNombreCentro();

        }
        else if ($usuario->getAfiliacion() == "INVESTIGADOR") {
            $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($usuario->getGrupoUsuario(), '', '', '', '', '', '');
            $grupo = $grupo_investigacion_model->rellenaDatos();
            $info_afiliacion = $grupo->getNombreGrupo();

        }
        else if ($usuario->getAfiliacion() == "ADMINISTRACION") {
            $info_afiliacion = $usuario->getNivelJerarquia(). ", " .$usuario->getNombrePuesto();
        }
        else {
            $info_afiliacion = "-";
        }

        new USUARIO_SHOWCURRENT_View($usuario, $info_afiliacion, $esModificar);
    }



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

    new USUARIO_JERARQUIA_View($toret, $vectorNiveles);
}

//Funcion para editar los datos
function edit($login_usuario){

    $usuario_model = recuperarDatosForm();
    if($_SESSION['rol']=='ADMIN'){
        $respuesta = $usuario_model->adminEDIT();
    }else{
        $respuesta = $usuario_model->EDIT();
    }
    if($respuesta === true){
        showcurrent($usuario_model->getLogin());
    }else{
        //"ERROR"
    }

}

//Funcion para recuperar datos de la BD y pasarselos a la vista para EDITAR
function showcurrentEdit($login_usuario){

    $esModificar = true;    //Indica a la vista que se van a poder editar datos

    $usuario_model = new USUARIO_Model('',$login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $usuario = $usuario_model->rellenaDatos();
    //TO DO: Si rellenaDatos devuelve el mensaje de error, llamar a la vista de error

    $fecha = explode("-", $usuario["fecha_nacimiento"]);
    $usuario->setFechaNacimiento($fecha[2]."/".$fecha[1]."/".$fecha[0]);

    if ($usuario->getRol() == "USUARIO_NORMAL"){
        $usuario->setRol("Usuario Normal");
    }
    else if ($usuario->getRol() == "ADMIN"){
        $usuario->setRol("Administrador");
        $info_afiliacion = "-";
    }

    else if ($usuario->getAfiliacion() == "DOCENTE") {
        $centro_model = new CENTRO_Model($usuario->getCentroUsuario(), '', '');
        $centro = $centro_model->rellenaDatos();

        $departamento_model = new DEPARTAMENTO_Models($usuario->getDepartUsuario(), '', '', '', '', '', '', '');
        $departamento = $departamento_model->rellenaDatos();

        $info_afiliacion = $departamento->getNombreDepartamento(). ", " . $centro->getNombreCentro();

    }
    else if ($usuario->getAfiliacion() == "INVESTIGADOR") {
        $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($usuario->getGrupoUsuario(), '', '', '', '', '', '');
        $grupo = $grupo_investigacion_model->rellenaDatos();
        $info_afiliacion = $grupo->getNombreGrupo();

    }
    else if ($usuario->getAfiliacion() == "ADMINISTRACION") {
        $info_afiliacion = $usuario->getNivelJerarquia(). ", " .$usuario->getNombrePuesto();
    }
    else {
        $info_afiliacion = "-";
    }

    new USUARIO_SHOWCURRENT_View($usuario, $info_afiliacion, $esModificar);
}

function recuperarDatosForm(){

    $user_model = new USUARIO_Model();

    $user_model->setNombre($_POST['nombre']);
    $user_model->setApellidos($_POST['apellidos']);
    $user_model->setPassword($_POST['password']);
    $user_model->setFechaNacimiento($_POST['fecha_nacimiento']);
    $user_model->setEmailUsuario($_POST['email_usuario']);
    $user_model->setTelefUsuario($_POST['telef_usuario']);
    $user_model->setDni($_POST['dni']);
    $user_model->setRol($_POST['rol']);
    $user_model->setAfiliacion($_POST['afiliacion']);

    if($_POST['nombre_puesto']==""){
        $user_model->setNombrePuesto(null);
    }else{
        $user_model->setNombrePuesto($_POST['nombre_puesto']);
    }

    if($_POST['nivel_jerarquia']==""){
        $user_model->setNivelJerarquia(null);
    }else{
        $user_model->setNivelJerarquia( $_POST['nivel_jerarquia']);
    }

    if(!isset($_POST['depart_usuario'])){
        $user_model->setDepartUsuario(null);
    }else{
        $user_model->setDepartUsuario($_POST['depart_usuario']);
    }

    if(!isset($_POST['grupo_usuario'])){
        $user_model->setGrupoUsuario(null);
    }else{
        $user_model->setGrupoUsuario($_POST['grupo_usuario']);
    }

    if(!isset($_POST['centro_usuario'])){
        $user_model->setCentroUsuario(null);

    }else{
        $user_model->setCentroUsuario($_POST['centro_usuario']);
    }
    return $user_model;

}

?>