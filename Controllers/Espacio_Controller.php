<?php

//DECLARACIÓN DE CONSTANTES
const TAM_PAG = 5;

//INCLUDES
include_once '../Models/ESPACIO_Model.php';
include_once '../Models/USUARIO_Model.php';
include_once '../Models/EDIFICIO_Model.php';
include_once '../Models/SOLICITUD_RESPONSABILIDAD_Model.php';
include '../Views/ESPACIO_SHOWALL_View.php';
include '../Views/ESPACIO_SHOWCURRENT_View.php';

session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch ($action) {
    case 'showall' :
        showall(!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
        break;
    case 'showcurrent':
        $espacio_id = $_GET['espacio_id'];
        showcurrent($espacio_id);
        break;
}

function showcurrent($espacio_id){

    $espacio_model = new ESPACIO_Model($espacio_id,'','', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    new ESPACIO_SHOWCURRENT_View($espacio);
}

function showall($num_pag){

    $espacio_model = new ESPACIO_Model('','','', '', '', '', '');
    $allEspacios = $espacio_model->SHOWALL();

    $num_pags = ceil(count($allEspacios) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag-1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allEspacios = array_slice($allEspacios, $inicio, $final);

    $nombreEdificios = [];
    $nombresResponsables = [];

    foreach ($allEspacios as $espacio){
        $edificio_model = new EDIFICIO_Model($espacio->getEdificioEsp(),'','','','','');
        $nombreEdificios[$espacio->getEdificioEsp()] = $edificio_model->getNombreById();


        $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio->getEspacioId(),'','','');
        $responsable_id = $solicitud_model->buscarResponsable();
        if ($responsable_id != 'Sin responsable'){
            $usuario_model = new USUARIO_Model($responsable_id, '','', '','','','','','','','','','','', '', '');
            $aux = $usuario_model->getNombreApellidosById();
            if($aux == 'No existe el usuario en la BD'){
                $nombresResponsables[$espacio->getEspacioId()] = 'Sin responsable';
            }
            else{
                $nombresResponsables[$espacio->getEspacioId()] = $aux;
            }
        }
    }

    new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags);
}

?>