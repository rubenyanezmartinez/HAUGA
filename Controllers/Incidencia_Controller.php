<?php

include_once '../Models/ESPACIO_Model.php';
include_once '../Models/AGRUPACION_Model.php';
include_once '../Models/USUARIO_Model.php';
include_once '../Models/EDIFICIO_Model.php';
include_once '../Models/INCIDENCIA_Model.php';
include_once '../Views/INCIDENCIA_ADD_View.php';

include '../Functions/Authentication.php';
session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch($action){
    case 'add':
        add();
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

            if(isset($_POST['autor'])){
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
    }

}
