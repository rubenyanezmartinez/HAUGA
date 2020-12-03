<?php
include '../Models/AGRUPACION_Model.php';
session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch ($action) {
    case 'showall' :
        showall();
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
        $vectorAgrup[$agrup->agrup_id]['nombre_agrup'] = $agrup->nombre_agrup;
        $vectorAgrup[$agrup->agrup_id]['ubicacion_agrup'] = $agrup->ubicacion_agrup;
    }

    include '../Views/AGRUPACION_SHOWALL_View.php';
    new AGRUPACION_SHOWALL_View($vectorAgrup);
}