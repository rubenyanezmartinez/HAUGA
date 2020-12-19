<?php

//DECLARACIÓN DE CONSTANTES
const TAM_PAG = 5;

//INCLUDES
include_once '../Models/ESPACIO_Model.php';
include_once '../Models/AGRUPACION_Model.php';
include_once '../Models/USUARIO_Model.php';
include_once '../Models/EDIFICIO_Model.php';
include_once '../Models/SOLICITUD_RESPONSABILIDAD_Model.php';
include '../Models/CENTRO_Model.php';
include '../Models/GRUPO_INVESTIGACION_Model.php';
include '../Models/DEPARTAMENTO_Models.php';
include '../Views/ESPACIO_SHOWALL_View.php';
include '../Views/ESPACIO_SHOWCURRENT_View.php';
include '../Views/ESPACIO_HISTORIAL_View.php';

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
    case 'verHistorial':
        $espacio_id = $_GET['espacio_id'];
        $nombre_espacio = $_GET['nombre_espacio'];
        $num_pag = (!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
        verHistorial($espacio_id, $nombre_espacio, $num_pag);
        break;
}

function verHistorial ($espacio_id, $nombre_espacio, $num_pag){
    $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id,'','','', '', '');
    $allResponsables = $solicitud_model->SHOWALL();

    $num_pags = ceil(count($allResponsables) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag-1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $responsables = array_slice($allResponsables, $inicio, $final);

    $nombresResponsables = [];
    foreach ($responsables as $responsable){
        //Nombre y Apellidos del responsable
        $usuario_model = new USUARIO_Model($responsable->getUsuarioId(), '','', '','','','','','','','','','','', '', '');
        $aux = $usuario_model->getNombreApellidosById();
        if($aux == 'No existe el usuario en la BD'){
            $nombresResponsables[$responsable->getUsuarioId()] = 'Sin responsable';
        }
        else{
            $nombresResponsables[$responsable->getUsuarioId()] = $aux;
        }
    }


    foreach ($responsables as $responsable){
        $fecha_inicio = explode("-", $responsable->getFechaInicio());
        $responsable->setFechaInicio($fecha_inicio[2]."/".$fecha_inicio[1]."/".$fecha_inicio[0]);

        $fecha_fin = explode("-", $responsable->getFechaFin());
        $responsable->setFechaFin($fecha_fin[2]."/".$fecha_fin[1]."/".$fecha_fin[0]);
    }

    new ESPACIO_HISTORIAL_View($espacio_id, $nombre_espacio, $responsables, $num_pag, $nombresResponsables);
}

function showcurrent($espacio_id){
    //Datos del espacio
    $espacio_model = new ESPACIO_Model($espacio_id,'','', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    //Nombre Responsable
    $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id,'','','', '', '');
    $responsable_id = $solicitud_model->buscarResponsable();
    $usuario_model = new USUARIO_Model($responsable_id, '','', '','','','','','','','','','','', '', '');
    $aux = $usuario_model->getNombreApellidosById();

    $nombresResponsable = "";
    if($aux == 'No existe el usuario en la BD'){
        $nombresResponsable = 'Sin responsable';
    }
    else{
        $nombresResponsable = $aux;
    }


    //Nombre edificio
    $edificio_model = new EDIFICIO_Model($espacio->getEdificioEsp(),'','','','','');
    $edificio = $edificio_model->rellenaDatos();
    $nombreEdificioYPlanta = $edificio->getNombreEdificio(). ', planta '. $espacio->getPlantaEsp();


    //Nombre agrupación edificios
    $agrupacion_model = new AGRUPACION_Model($edificio->getAgrup_edificio(), '','');
    $agrupacion_model->rellenaDatos();
    $nombreAgrupacion = $agrupacion_model->getNombreAgrup();



    //Información afiliación del responsable
    $usuario_model = new USUARIO_Model($responsable_id,'','','','','','','','','','','','','','','');
    $usuario = $usuario_model->rellenaDatosById();

    if ($usuario == 'Error inesperado al intentar cumplir su solicitud de consulta'){
        $info_afiliacion = "-";
    }
    else if ($usuario->getAfiliacion() == "DOCENTE") {

        $centro_model = new CENTRO_Model($usuario->getCentroUsuario(), '', '');
        $centro = $centro_model->rellenaDatos();

        $departamento_model = new DEPARTAMENTO_Models($usuario->getDepartUsuario(), '', '', '', '', '', '', '');
        $departamento = $departamento_model->rellenaDatos();

        $info_afiliacion = $departamento->getNombreDepartamento() . ", " . $centro->getNombreCentro();

    }
    else if ($usuario->getAfiliacion() == "INVESTIGADOR") {

        $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($usuario->getGrupoUsuario(), '', '', '', '', '', '');
        $grupo = $grupo_investigacion_model->rellenaDatos();

        $info_afiliacion = $grupo->getNombreGrupo();

    }
    else if ($usuario->getAfiliacion() == "ADMINISTRACION") {

        $info_afiliacion = $usuario->getNivelJerarquia() . ", " . $usuario->getNombrePuesto();

    }
    else {
        $info_afiliacion = "-";
    }


    new ESPACIO_SHOWCURRENT_View($espacio, $nombresResponsable, $nombreEdificioYPlanta, $nombreAgrupacion, $info_afiliacion);
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


        $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio->getEspacioId(),'','','', '', '');
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