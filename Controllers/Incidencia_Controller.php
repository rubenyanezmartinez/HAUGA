<?php

include_once '../Models/ESPACIO_Model.php';
include_once '../Models/AGRUPACION_Model.php';
include_once '../Models/USUARIO_Model.php';
include_once '../Models/EDIFICIO_Model.php';
include_once '../Models/GRUPO_INVESTIGACION_Model.php';
include_once '../Models/INCIDENCIA_Model.php';
include_once '../Models/DEPARTAMENTO_Models.php';
include_once '../Views/INCIDENCIA_ADD_View.php';
include_once '../Views/INCIDENCIA_SHOWALL_View.php';

include '../Functions/Authentication.php';
session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch($action){
    case 'add':
        add();
        break;
    case 'showall':
        showall();
        break;
    case 'aceptar':
        aceptar($_GET['incidencia_id']);
        break;
    case 'denegar':
        denegar($_GET['incidencia_id']);
        break;
    default:
        echo "default del controlador de incidencias";
        break;
}

function add(){
    if(!$_POST){
        $agrupacion_model = new AGRUPACION_Model('','','');
        $edificio_model = new EDIFICIO_Model('','','','','','');
        $espacio_model = new ESPACIO_Model('','','','','','','');

        $agrupaciones = $agrupacion_model->SHOWALL();
        $edificios = $edificio_model->SHOWALL();
        $espacios = $espacio_model->SHOWALL();

        new INCIDENCIA_ADD_View($agrupaciones, $edificios, $espacios);
    }else{
        if(isset($_POST['espacio_id'])){

            $espacio_id = $_POST['espacio_id'];

            if(!IsAuthenticated()){
                $autor = $_POST['autor'];
            }else{
                $usuario_model = new USUARIO_Model('',$_SESSION['login'],'','','','',
                    '','','','','','','','','','');
                $usuario_model->rellenaDatos();
                $autor = $usuario_model->getNombre() .' ' .$usuario_model->getApellidos();
            }
            $incidencia_model = new INCIDENCIA_Model('',$_POST['descripcion_incid'],'PEND',$espacio_id,$autor);
            $incidencia_model->add();
        }

        header('Location:../Controllers/Index_Controller.php');
    }

}

function aceptar($incidencia_id){
    $incidencia = new INCIDENCIA_Model($incidencia_id,'','','','');
    //$incidencia = $incidencia->rellenaDatos();

    $incidencia->updateEstado('ACEPT');
    header('Location:../Controllers/Incidencia_Controller.php?action=showall');
}

function denegar($incidencia_id){
    $incidencia = new INCIDENCIA_Model($incidencia_id,'','','','');
    //$incidencia = $incidencia->rellenaDatos();

    $incidencia->updateEstado('DENEG');
    header('Location:../Controllers/Incidencia_Controller.php?action=showall');
}

function showall(){
    $incidencia_model = new INCIDENCIA_Model('','','','','');
    $espacio_model = new ESPACIO_Model('', '', '', '', '', '', '');

    $usuario_autenticado = new USUARIO_Model('',$_SESSION['login'],'','','','',
        '','','','','','','','','','');
    $user = $usuario_autenticado->rellenaDatos();



    $permiso = permisosIncidencias($user);

    if($permiso != 'NO'){
        if($permiso == 'ADMIN'){
            $incidencias = $incidencia_model->SHOWALL();
        }else{
            $incidencias = $incidencia_model->buscarIncidencias($permiso);
        }
    }else{
        header('Location:../Controllers/Index_Controller.php');
    }


    $nombreEspacios = [];

    foreach($incidencias as $incidencia){
        $espacio_model = new ESPACIO_Model($incidencia->getEspacioAfectado(), '', '', '', '', '', '');
        $nombreEspacios[$incidencia->getEspacioAfectado()] = $espacio_model->getNombreById();
    }

    new INCIDENCIA_SHOWALL_View($incidencias, $nombreEspacios);
}

function permisosIncidencias($usuario_autenticado){

    if($usuario_autenticado->getRol() == 'ADMIN'){
        return 'ADMIN';
    }

    else if ($usuario_autenticado->getAfiliacion() == 'ADMINISTRACION' && $usuario_autenticado->getNombrePuesto() == 'Conserjería'
        || $usuario_autenticado->getNombrePuesto() == 'Conserjeria'
        || $usuario_autenticado->getNombrePuesto() == 'conserjería'
        || $usuario_autenticado->getNombrePuesto() == 'conserjeria'
        || $usuario_autenticado->getNombrePuesto() == 'conserje'
        || $usuario_autenticado->getNombrePuesto() == 'Conserje') {

        return 'COMUN';
    }

    else if ($usuario_autenticado->getAfiliacion() == 'DOCENTE'){

        $departamento_model = new DEPARTAMENTO_Models('', '', '', '', '', '', '', '');
        $departamentos = $departamento_model->SHOWALL();

        foreach ($departamentos as $dep) {
            if ($dep->getResponsableDepart() == $usuario_autenticado->getUsuarioId()) {
                return 'DOCENCIA';
            }
        }
    }

    else if($usuario_autenticado->getAfiliacion() == 'INVESTIGADOR') {

        $grupo_model = new GRUPO_INVESTIGACION_Model('', '', '', '', '', '', '', '');
        $grupos = $grupo_model->SHOWALL();

        foreach ($grupos as $grupo) {
            if ($grupo->getResponsableGrupo() == $usuario_autenticado->getUsuarioId()) {
                return 'INVESTIGACION';
            }
        }
    }

    else if($usuario_autenticado->getAfiliacion() == 'ADMINISTRACION') {

        return 'PAS';
    }

    else{
        return 'NO';
    }

}
