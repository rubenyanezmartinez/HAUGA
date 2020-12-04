<?php
include '../Models/AGRUPACION_Model.php';
session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch ($action) {
    case 'showall' :
        showall();
        break;
    case 'showcurrent':
        showcurrent($_GET['agrup_id']);
        break;
    case 'add':
        add();
        break;
    default:
        echo('default del switch de agrupacio controller');
        break;
}

function showall(){
    $agrupacion_model = new AGRUPACION_Model('','','');
    $allAgrup = $agrupacion_model->SHOWALL();

    $vectorAgrup = [];
    foreach ($allAgrup as $agrup){
        $vectorAgrup[$agrup->agrup_id]['agrup_id'] = $agrup->agrup_id;
        $vectorAgrup[$agrup->agrup_id]['nombre_agrup'] = $agrup->nombre_agrup;
        $vectorAgrup[$agrup->agrup_id]['ubicacion_agrup'] = $agrup->ubicacion_agrup;
    }

    include '../Views/AGRUPACION_SHOWALL_View.php';
    new AGRUPACION_SHOWALL_View($vectorAgrup);
}

function showcurrent($agrup_id){
    include '../Views/AGRUPACION_SHOWCURRENT_View.php';
    $agrup_model = new AGRUPACION_Model($agrup_id, '','');
    $agrupacion = $agrup_model->rellenaDatos();

    if($agrupacion == 'Error'){
        new AGRUPACION_SHOWCURRENT_View();
    } else {
        new AGRUPACION_SHOWCURRENT_View($agrupacion, false, false);
    }
}

function add(){
    include '../Views/AGRUPACION_SHOWCURRENT_View.php';
    if(!$_POST){
        $agrupacion = array('agrup_id' => '', 'nombre_agrup' => '', 'ubicacion_agrup' => '');
        new AGRUPACION_SHOWCURRENT_View($agrupacion, false, true);
    } else {
        $nombre_agrup = $_POST['nombre_agrup']=='' ? null : $_POST['nombre_agrup'];
        $ubicacion_agrup = $_POST['ubicacion_agrup']=='' ? null : $_POST['ubicacion_agrup'];

        $agrupacion_model = new AGRUPACION_Model(null, $nombre_agrup, $ubicacion_agrup);
        $respuesta = $agrupacion_model->add();

        if($respuesta === true){
            header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
        } else{
            $agrupacion = array('agrup_id' => '', 'nombre_agrup' => $nombre_agrup, 'ubicacion_agrup' => $ubicacion_agrup);
            new AGRUPACION_SHOWCURRENT_View($agrupacion, false, true);
        }
    }
}