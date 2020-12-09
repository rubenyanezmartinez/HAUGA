<?php
include '../Models/AGRUPACION_Model.php';
session_start();

const TAM_PAG = 5;

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch ($action) {
    case 'showall' :
        showall(!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
        break;
    case 'showcurrent':
        showcurrent($_GET['agrup_id']);
        break;
    case 'add':
        include_once '../Functions/esAdministrador.php';
        include_once '../Functions/Authentication.php';
        if(IsAuthenticated() && esAdministrador()){
            add();
        } else {
            header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
        }
        break;
    case 'delete':
        if($_SESSION['rol'] == "ADMIN"){
            if(isset($_GET["agrup_id"])){
                $agrupacion_model = new AGRUPACION_Model($_GET["agrup_id"],"","");
                $agrupacion_model->delete();
                header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
            }
        }else{
            //error
        }
        break;
    default:
        echo('default del switch de agrupacio controller');
        break;
}

function showall($num_pag){
    include_once '../Models/EDIFICIO_Model.php';
    $agrupacion_model = new AGRUPACION_Model('','','');
    $allAgrup = $agrupacion_model->SHOWALL();

    $num_pags = ceil(count($allAgrup) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag-1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $numEdificio = [];

    $allAgrup = array_slice($allAgrup, $inicio, $final);

    foreach ($allAgrup as $agrup){
        $edficio_modelo = new EDIFICIO_Model('','','','','',$agrup->getAgrupId());

        $numEdificio[$agrup->getAgrupId()] = $edficio_modelo->devolverNumeroEdificioAgrupacion();
    }

    include '../Views/AGRUPACION_SHOWALL_View.php';
    new AGRUPACION_SHOWALL_View($allAgrup, $numEdificio, $num_pags);
}

function showcurrent($agrup_id){
    include '../Views/AGRUPACION_SHOWCURRENT_View.php';
    $agrup_model = new AGRUPACION_Model($agrup_id, '','');
    $agrupacion = $agrup_model->rellenaDatos();

    if($agrupacion == 'Error'){
        new AGRUPACION_SHOWCURRENT_View();
    } else {
        new AGRUPACION_SHOWCURRENT_View($agrupacion, false);
    }
}

function add(){
    include '../Views/AGRUPACION_SHOWCURRENT_View.php';
    if(!$_POST){
        $agrupacion = array('agrup_id' => '', 'nombre_agrup' => '', 'ubicacion_agrup' => '');
        new AGRUPACION_SHOWCURRENT_View($agrupacion, true);
    } else {
        $nombre_agrup = $_POST['nombre_agrup']=='' ? null : $_POST['nombre_agrup'];
        $ubicacion_agrup = $_POST['ubicacion_agrup']=='' ? null : $_POST['ubicacion_agrup'];

        $agrupacion_model = new AGRUPACION_Model(null, $nombre_agrup, $ubicacion_agrup);
        $respuesta = $agrupacion_model->add();

        if($respuesta === true){
            header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
        } else{
            $agrupacion = array('agrup_id' => '', 'nombre_agrup' => $nombre_agrup, 'ubicacion_agrup' => $ubicacion_agrup);
            new AGRUPACION_SHOWCURRENT_View($agrupacion, true);
        }
    }
}