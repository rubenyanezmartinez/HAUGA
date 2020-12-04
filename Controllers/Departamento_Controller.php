<?php
include '../Functions/Authentication.php';
include '../Functions/Desconectar.php';
include '../Models/Access_DB.php';
include '../Models/USUARIO_Model.php';
include '../Models/EDIFICIO_Model.php';
include '../Models/DEPARTAMENTO_Models.php';
session_start();


if(!IsAuthenticated()){
    login();
}else{
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
        default: echo('default del switch departamento_controller');
            break;
    }
}

function add(){
    $edificio = new EDIFICIO_Model('','','','','','');  //Crea un edificio vacio
    $edificios = $edificio->SHOWALL(); //En $Array con todos los edificio
    $usuario = new USUARIO_Model('','','','','','','', '','','','','','','','','');  //Crea un usuario vacio
    $usuarios = $usuario->SHOWALL(); //En $Array con todos los usuarios
    include '../Views/DEPARTAMENTO_ADD_View.php';
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

function recuperarDatosForm(){

}

?>