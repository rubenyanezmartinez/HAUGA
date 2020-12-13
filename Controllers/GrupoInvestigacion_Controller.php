<?php
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';

include '../Models/Access_DB.php';
include '../Models/GRUPO_INVESTIGACION_Model.php';
include '../Models/USUARIO_Model.php';

include '../Views/GRUPOINVESTIGACION_ADD_View.php';
include '../Views/GRUPOINVESTIGACION_SHOWALL_View.php';
include '../Views/GRUPOINVESTIGACION_SHOWCURRENT_View.php';
session_start();

const TAM_PAG = 5;

if(!isset($_GET['action'])){
    $action = '';
} else{
    $action = $_GET['action'];
}

switch($action){
    case 'add':
        if($_SESSION['rol']=='ADMIN'){
            add();
        }else{
            header('Location:../Controllers/Index_Controller.php');
        }
        break;
    case 'showall':
        showall(!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
        break;
    case 'showcurrent':
        showcurrent($_GET['grupo_id']);
        break;
    default:  echo('default del switch grupoInvestigacion_controller');
        break;
}

function add(){
    $esModificar = false;
    if(!isset($_POST['nombre_grupo'])) {//Antes de cubrir el formulario
        $grupo = new GRUPO_INVESTIGACION_Model( null, '','','',
            '', '','');
        $respuesta = false;
        $usuariosModel = new USUARIO_Model('','','','','','',
            '','','','','','','','',
            '','');
        $usuarios = $usuariosModel->SHOWALL();
        //Llamar al formulario ADD
        new GRUPOINVESTIGACION_ADD_View($grupo, $esModificar, $respuesta, $usuarios);
    }else{
        if(!isset($_POST['responsable_grupo'])){
            $responsable_grupo = null;
        }else{
            $responsable_grupo = $_POST['responsable_grupo'];
        }
        $grupo = new GRUPO_INVESTIGACION_Model(null, $_POST['nombre_grupo'], $_POST['telef_grupo'],
            $_POST['lineas_investigacion'], $_POST['area_conoc_grupo'],$_POST['email_grupo'] ,$responsable_grupo);
        $respuesta = $grupo->registrar();
        if($respuesta === true){
            header('Location:../Controllers/GrupoInvestigacion_Controller.php?action=showall');
        }else{
            $esModificar = false;
            //Mostramos datos introducidos y mensaje de error
            new GRUPOINVESTIGACION_ADD_View($grupo, $esModificar, $respuesta);
        }
    }
}

function showall($num_pag){
    $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model('','','','','','','','');
    $allGruposInvestigacion = $grupo_investigacion_model->SHOWALL();

    $max_pags = ceil(count($allGruposInvestigacion) / TAM_PAG);
    $num_pag = $num_pag > $max_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag-1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allGruposInvestigacion = array_slice($allGruposInvestigacion, $inicio, $final);

    $loginResponsable = array();
    foreach ($allGruposInvestigacion as $grupo) {
        $usuario_model = new USUARIO_Model($grupo->getResponsableGrupo(), '', '','','','','','','','','','','','','','');
        $loginResponsable[$grupo->getGrupoId()] = $usuario_model->getLoginById();
    }

    new GRUPOINVESTIGACION_SHOWALL_View($allGruposInvestigacion, $loginResponsable, $num_pag);
}

function showcurrent ($grupo_id){
    $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($grupo_id,'','','','','','');
    $grupo_investigacion = $grupo_investigacion_model->rellenaDatos();

    if($grupo_investigacion != 'Error'){

        $usuarioModel = new USUARIO_Model($grupo_investigacion->getResponsableGrupo(), '','','','','','','','','','','','','','','');
        $responsableLogin = $usuarioModel->getLoginById();

        new GRUPOINVESTIGACION_SHOWCURRENT_View($grupo_investigacion, $responsableLogin);
    } else {
        new GRUPOINVESTIGACION_SHOWCURRENT_View();
    }


}

?>