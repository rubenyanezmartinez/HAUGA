<?php

//DECLARACIÓN DE CONSTANTES
const TAM_PAG = 5;

//INCLUDES
include_once '../Models/EDIFICIO_Model.php';
include_once '../Models/ESPACIO_Model.php';
include_once '../Models/AGRUPACION_Model.php';

include '../Views/EDIFICIO_ADD_View.php';
include '../Views/EDIFICIO_SHOWALL_View.php';

include '../Functions/Authentication.php';


session_start();

$action = !isset($_GET['action']) ? '' : $_GET['action'];

switch ($action) {
    case 'add':
        if ($_SESSION['rol']=='ADMIN'){
            add();
        }
        break;
    case 'showall':
        showall((!isset($_GET['num_pag']) || ($_GET['num_pag'] == '' ? 1 : $_GET['num_pag'])), $_GET['agrupacion_id']);
        break;
    case 'delete':
        if($_SESSION['rol']=='ADMIN') {
            delete();
        }
        break;
    default:
        echo "default del controlador de edificios";
        break;
}

function add(){
    $esModificar = false;
    if(!isset($_POST['nombre_edif'])){
        //Mostrar formulario de añadir edificio
        $datos = new EDIFICIO_Model(null,'','','','','');
        $agrupacion_model = new AGRUPACION_Model('','','');
        $agrupaciones = $agrupacion_model->SHOWALL();
        new EDIFICIO_ADD_View($datos, $agrupaciones, $esModificar);
    }else{
        //Recuperar datos de formulario y enviarlos al modelo
        if(isset($_POST['nombre_edif'])){
            $agrup_edificio = $_POST['agrup_edificio']=='' ? null : $_POST['agrup_edificio'];
            $edificio = new EDIFICIO_Model(null, $_POST['nombre_edif'], $_POST['direccion_edif'], $_POST['telef_edif'],
                $_POST['num_plantas'], $agrup_edificio);
            $respuesta = $edificio->add();
            if($respuesta === true){
                header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
            }else{
                $agrupacion_model = new AGRUPACION_Model('','','');
                $agrupaciones = $agrupacion_model->SHOWALL();
                //Llamamos de nuevo a la vista con los datos introducidos previamente
                new EDIFICIO_ADD_View($edificio, $agrupaciones, $esModificar, $respuesta);
            }
        }
    }
}
function delete(){
    if(isset($_GET['edificio_id'])){//Antes de confirmar el borrado
        $edificio = new EDIFICIO_Model($_GET['edificio_id'], '', '', '','', '');
        $espacio = new ESPACIO_Model('','','','','','',$_GET['edificio_id']); //Crea espacios del edificio
        $respuestaEspacios = $espacio->borrarEspaciosEdificio();
        if($respuestaEspacios === true){
            $respuesta = $edificio->DELETE(); //Elimina el edificio
            if($respuesta === true){
                header('Location:../Controllers/AGRUPACION_Controller.php?action=showall');
            }
        }

    }
}

function showall($num_pag, $agrupacion_id)
{

    $edificio_model = new EDIFICIO_Model('', '', '', '', '', $agrupacion_id);
    $allEdificios = $edificio_model->devolverEdificiosPorAgrupacion();

    $num_pags = ceil($edificio_model->devolverNumeroEdificioAgrupacion() / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag - 1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allEdificios = array_slice($allEdificios, $inicio, $final);

    $agrupacion_model = new AGRUPACION_Model($agrupacion_id, '', '');
    $agrupacion = $agrupacion_model->rellenaDatos();

    new EDIFICIO_SHOWALL_View($allEdificios, $agrupacion, $num_pags, '');
}
?>