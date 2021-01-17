<?php
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
include '../Models/EDIFICIO_Model.php';
include '../Models/CENTRO_Model.php';
include '../Views/CENTRO_SHOWALL_View.php';
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
    $edificio = new EDIFICIO_Model('','','','','','');  //Crea un edificio vacio
    $edificios = $edificio->SHOWALL(); //En $Array con todos los edificio
    $usuario = new USUARIO_Model('','','','','','','', '','','','','','','','','');  //Crea un usuario vacio
    $usuarios = $usuario->SHOWALL(); //En $Array con todos los usuarios
    if(!$_POST){//Antes de cubrir el formulario
        $datos = ["nombre_depart" => '', "codigo_depart" => '', "telef_depart" => '', "email_depart" => '',
            "area_conc_depart" => '', "responsable_depart" => '', "edificio_depart" => '',"respuesta"=>''];
        new DEPARTAMENTO_ADD_View($datos, $edificios, $usuarios);
    } else {

        $departamento = new DEPARTAMENTO_Models(null, $_POST['nombre_depart'], $_POST['codigo_depart'],$_POST['telef_depart'], $_POST['email_depart']
            ,$_POST['area_conc_depart'],$_POST['responsable_depart'],$_POST['edificio_depart']);//DEPARTAMENTO con los datos introducidos en el formulario.

        $respuesta = $departamento->registrar();

        if($respuesta === true){
            header('Location:../Controllers/Departamento_Controller.php?action=showall');
        }else{
            //Mostramos datos introducidos y mensaje de error
            $departamento = new DEPARTAMENTO_ADD_View(["nombre_depart" => $_POST['nombre_depart'] , "codigo_depart" => $_POST['codigo_depart'], "telef_depart" => $_POST['telef_depart'], "email_depart" => $_POST['email_depart'],
                "area_conc_depart" => $_POST['area_conc_depart'], "responsable_depart" => $_POST['responsable_depart'], "edificio_depart" => $_POST['edificio_depart'],"respuesta"=>$respuesta], $edificios, $usuarios);
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
        $centro = new CENTRO_Model($_GET['centro_id']);
        $respuesta = $centro->DELETE(); //Elimina el departamento
        if($respuesta === true){
            header('Location:../Controllers/Centro_Controller.php?action=showall');
        }
    }
}

?>