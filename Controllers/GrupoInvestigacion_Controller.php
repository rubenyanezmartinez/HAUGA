<?php
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';

include '../Models/Access_DB.php';
include '../Models/GRUPO_INVESTIGACION_Model.php';
include '../Models/USUARIO_Model.php';
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
        echo('showall de grupos de investigacion');
        break;
    default:  echo('default del switch grupoInvestigacion_controller');
        break;
}

function add(){
    $esModificar = false;
    if(!isset($_POST['nombre_grupo'])) {//Antes de cubrir el formulario
        $datos = new GRUPO_INVESTIGACION_Model( null, '','','',
            '', '','');
        $respuesta = false;
        //Llamar al formulario ADD
        new GRUPOINVESTIGACION_ADD_View($datos, $esModificar, $respuesta);
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