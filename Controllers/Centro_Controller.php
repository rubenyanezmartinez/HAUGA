<?php
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
include '../Models/EDIFICIO_Model.php';
include '../Models/CENTRO_Model.php';
include '../Views/CENTRO_SHOWALL_View.php';
include '../Views/CENTRO_ADD_View.php';
session_start();

const TAM_PAG = 5;

if(!isset($_GET['action'])){
    $action = '';
} else{
    $action = $_GET['action'];
}

switch($action){
    case 'add':    //Caso para crear un departamento
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
        showcurrent($_GET['depart_id']);
        break;
    case 'delete':
        if($_SESSION['rol']=='ADMIN') {
            delete();
        }
        break;
    default: echo('default del switch departamento_controller');
        break;
}


function add(){
    $centro = new CENTRO_Model(null,'','');  //Crea un centro vacio
    $centros = $centro->SHOWALL(); //En $Array con todos los centros

    $edificio_model = new EDIFICIO_Model('', '', '', '', '', '');
    $edificios = $edificio_model->SHOWALL();
    if(!$_POST){//Antes de cubrir el formulario
        new CENTRO_ADD_View($centro, $edificios);
    } else {

        $centro = new CENTRO_Model(null, $_POST['nombre_centro'], $_POST['edificio_centro']);//CENTRO con los datos introducidos en el formulario.

        $respuesta = $centro->add();

        if($respuesta === true){
            header('Location:../Controllers/Centro_Controller.php?action=showall');
        }else{
            //Mostramos datos introducidos y mensaje de error
            $centro = new CENTRO_ADD_View(new CENTRO_Model(null, '', ''), $edificios);
        }
    }
}

function showall($num_pag){
    $centro_model = new CENTRO_Model('','','');
    $allCentros = $centro_model->SHOWALL();

    $max_pags = ceil(count($allCentros) / TAM_PAG);
    $num_pag = $num_pag > $max_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag-1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allCentros = array_slice($allCentros, $inicio, $final);

    $nombreEdificios = array();
    foreach ($allCentros as $centro) {
        $edificio_model = new EDIFICIO_Model($centro->getEdificioCentro(), '', '','','','');
        $nombreEdificios[$centro->getCentroId()] = $edificio_model->getNombreById();
    }

    new CENTRO_SHOWALL_View($allCentros, $nombreEdificios, $num_pag);
}

function showcurrent($depart_id){
    $departamentoModel = new DEPARTAMENTO_Models($depart_id,'','','','','','','');
    $departamento = $departamentoModel->rellenaDatos();

    if($departamento != 'Error'){
        $edificioModel = new EDIFICIO_Model($departamento->getEdificioDepart(),'','','','','');
        $edificioNombre = $edificioModel->getNombreById();

        $usuarioModel = new USUARIO_Model($departamento->getResponsableDepart(), '','','','','','','','','','','','','','','');
        $responsableLogin = $usuarioModel->getLoginById();

        new DEPARTAMENTO_SHOWCURRENT_View($departamento, $responsableLogin, $edificioNombre);
    } else {
        new DEPARTAMENTO_SHOWCURRENT_View();
    }


}

function delete(){
    if(isset($_GET['centro_id'])){//Antes de confirmar el borrado
        $centro = new CENTRO_Model($_GET['centro_id'], '', '');
        $respuesta = $centro->DELETE(); //Elimina el departamento
        if($respuesta === true){
            header('Location:../Controllers/Centro_Controller.php?action=showall');
        }
    }
}

?>