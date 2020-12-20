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
include '../Views/ESPACIO_ADD_View.php';
include '../Views/ESPACIO_HISTORIAL_View.php';

include '../Functions/Authentication.php';

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
    case 'comprobarPermisoBorrado':
        $espacio_id = $_GET['espacio_id'];
        $login_usuario = $_SESSION['login'];
        $num_pag = (!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
        comprobarPermisoBorrado($espacio_id, $login_usuario, $num_pag);
        break;
    case 'delete':
        $espacio_id = $_GET['espacio_id'];
        $login_usuario = $_SESSION['login'];
        delete($espacio_id, $login_usuario);
        break;
    case 'add':
        if (IsAuthenticated()) {
            add();
        } else {
            header('Location:../Controllers/Espacio_Controller.php?action=showall');
        }
        break;
    case 'edit':
        if(isset($_GET['espacio_id'])){
            if(IsAuthenticated() && tienePermisos($_SESSION['login'], $_GET['espacio_id'])) {
                edit($_GET['espacio_id']);
            } else {
                list($allEspacios, $num_pags, $nombreEdificios, $nombresResponsables) = preparar_showall(!isset($_GET['num_pag']) || $_GET['num_pag'] == '' ? 1 : $_GET['num_pag']);
                new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables,$num_pags,'No aceptado', $_GET['espacio_id']);
            }
        } else {
            header('Location:../Controllers/Espacio_Controller.php?action=showall');
        }
        break;
    default:
        echo "default del controlador de espacios";
        break;
}

function edit($espacio_id){
    $espacio = new ESPACIO_Model($espacio_id, '','','','','','');
    $espacio = $espacio->rellenaDatos();

    $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id,'','','','','');
    $responsable_id = $solicitud_model->buscarResponsable();
    if($responsable_id != '') {
        $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        $responsable = $usuario_model->getNombreApellidosById();
    } else {
        $responsable = '';
    }

    $edificio_model = new EDIFICIO_Model('','','','','','');
    $edificios = $edificio_model->SHOWALL();

    if(!$_POST){
        new ESPACIO_ADD_View($espacio, $edificios, $responsable,false);
    } else {
        $ruta_antigua = $espacio->getRutaImagen();
        if(file_exists($_FILES['imagen_espacio']['tmp_name'])) {
            $imagen_subida = pathinfo($_FILES['imagen_espacio']['name']);
            $nueva_extension = $imagen_subida['extension'];
            $ruta_nueva = pathinfo($ruta_antigua);
            $ruta_nueva = $ruta_nueva['dirname'] . '/' . $ruta_nueva['filename'] . '.' . $nueva_extension;
            $espacio->setRutaImagen($ruta_nueva);
        }

        $espacio->setCategoriaEsp($_POST['categoria_esp']);
        $espacio->setNombreEsp($_POST['nombre_esp']);
        $espacio->setTarifaEsp($_POST['tarifa_esp']);


        if (isset($_POST['esResponsable']) && $_POST['esResponsable'] == 'si') {
            $responsable = $_SESSION['login'];

            $usuario_model = new USUARIO_Model('', $responsable, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
            $usuario_model = $usuario_model->rellenaDatos();
            $responsable_nuevo = $usuario_model->getUsuarioId();

            if($responsable != '') {
                $solicitud = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
                $solicitud->eliminarResponsable();
            }

            $solicitud = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, $responsable_nuevo, date("Y-m-d"), "0000-00-00", 'DEFIN', $espacio->getTarifaEsp());
            $solicitud->add();
        }

        $respuesta_espacio = $espacio->edit();
        if($respuesta_espacio === true){
            if(file_exists($_FILES['imagen_espacio']['tmp_name'])) {
                unlink($ruta_antigua);
                move_uploaded_file($_FILES['imagen_espacio']['tmp_name'], $ruta_nueva);
            }
            header('Location:../Controllers/Espacio_Controller.php?action=showall');
        } else {
            new ESPACIO_ADD_View($espacio, $edificios, $responsable,false);
        }
    }
}

function add()
{

    if (!$_POST) {
        $espacio = new ESPACIO_Model('', '', '', '', '', '', '');

        $edificio_model = new EDIFICIO_Model('', '', '', '', '', '');
        $edificios = $edificio_model->SHOWALL();

        new ESPACIO_ADD_View($espacio, $edificios, '',true);
    } else {

        $directorio_imagenes = "../Models/Imagenes_Espacios/";
        $nombre_imagen = $_POST['nombre_esp'];
        $nombre_imagen_aux = $nombre_imagen;

        $i = 1;
        while (file_exists($directorio_imagenes . $nombre_imagen_aux . '.' . strtolower(pathinfo($_FILES['imagen_espacio']['name'], PATHINFO_EXTENSION)))) {
            $nombre_imagen_aux = $nombre_imagen . $i;
            $i++;
        }
        $nombre_imagen = $nombre_imagen_aux;
        $ruta_imagen = $directorio_imagenes . $nombre_imagen . '.' . strtolower(pathinfo($_FILES['imagen_espacio']['name'], PATHINFO_EXTENSION));

        $espacio = new ESPACIO_Model(null, $_POST['nombre_esp'], $ruta_imagen, $_POST['tarifa_esp'], $_POST['categoria_esp'], $_POST['planta_esp'], $_POST['edificio_esp']);
        $respuesta_espacio = $espacio->add();

        if (isset($_POST['esResponsable']) && $_POST['esResponsable'] == 'si') {
            $responsable = $_SESSION['login'];

            $usuario_model = new USUARIO_Model('', $responsable, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
            $usuario_model = $usuario_model->rellenaDatos();
            $responsable = $usuario_model->getUsuarioId();

            $solicitud = new SOLICITUD_RESPONSABILIDAD_Model($espacio->getEspacioId(), $responsable, date("Y-m-d"), "0000-00-00", 'DEFIN', $espacio->getTarifaEsp());
            $solicitud->add();
        }

        if ($respuesta_espacio === true) {
            move_uploaded_file($_FILES['imagen_espacio']['tmp_name'], $ruta_imagen);
            header('Location:../Controllers/Espacio_Controller.php?action=showall');
        } else {
            $edificio_model = new EDIFICIO_Model('', '', '', '', '', '');
            $edificios = $edificio_model->SHOWALL();

            new ESPACIO_ADD_View($espacio, $edificios, '',true);
        }
    }

}

function delete($espacio_id, $login_usuario)
{

    //COMRPOBACION DE SI EL USUARIO TIENE LOS PERMISOS PARA PODER REALIZAR EL BORRADO DEL ESPACIO:
    $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    //SI NO EXISTE EL ESPACIO REEDIRIGIR A LA PÁGINA PRINCIPAL
    if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
        header('Location:../Controllers/Espacio_Controller.php?action=showall');
    } //EN CASO CONTRARIO COMPROBAR SI TIENE PERMISOS PARA PODER REALIZAR EL BORRADO
    else {
        //UN USUARIO CON EL ROL DE ADMINISTRADOR SIEMPRE TIENE PERMISOS PARA REALIZAR EL BORRADO
        if ($_SESSION['rol'] == "ADMIN") {

            $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
            $espacio = $espacio_model->rellenaDatos();

            if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
                header('Location:../Controllers/Espacio_Controller.php?action=showall');
            } else {
                $respuesta = $espacio->DELETE();

                if ($respuesta === true) {
                    unlink($espacio->getRutaImagen());
                    header('Location:../Controllers/Espacio_Controller.php?action=showall');
                }
            }

            header('Location:../Controllers/Espacio_Controller.php?action=showall');
        } //EN CASO CONTARIO COMPROBAR SI EL QUE INTENTA ELIMINAR ES EL RESPONSABLE DEL CENTRO, DEPARTAMENTO, GRUPO DE INVESTIGACIÓN, TIENE MAYOR PUESTO O ES CONSERJERIA
        else {
            $categoria_espacio = $espacio->getCategoriaEsp();

            //Buscar quien es el responsable del espacio:
            $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
            $responsable_id = $solicitud_model->buscarResponsable();

            if ($responsable_id == 'Sin responsable' || $responsable_id == NULL) {
                header('Location:../Controllers/Espacio_Controller.php?action=showall');
            } else {
                $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $responsable_espacio = $usuario_model->rellenaDatosById();

                //Buscar usuario logueado:
                $usuario_model = new USUARIO_Model('', $login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $usuario_autenticado = $usuario_model->rellenaDatos();

                switch ($categoria_espacio) {
                    case 'DOCENCIA':
                        //Comprobar el departamento:
                        $departamento_id = $responsable_espacio->getDepartUsuario();

                        $departamento_model = new DEPARTAMENTO_Models($departamento_id, '', '', '', '', '', '', '');
                        $departamento = $departamento_model->rellenaDatos();

                        if ($departamento->getResponsableDepart() == $usuario_autenticado->getUsuarioId()) {

                            $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
                            $espacio = $espacio_model->rellenaDatos();


                            if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
                                header('Location:../Controllers/Espacio_Controller.php?action=showall');
                            } else {
                                $respuesta = $espacio->DELETE();

                                if ($respuesta === true) {
                                    unlink($espacio->getRutaImagen());
                                    header('Location:../Controllers/Espacio_Controller.php?action=showall');
                                }
                            }


                        } else {
                            header('Location:../Controllers/Espacio_Controller.php?action=showall');
                        }
                        break;
                    case 'INVESTIGACION':
                        //Comprobar grupo de investigación
                        $grupo_id = $responsable_espacio->getGrupoUsuario();

                        $grupo_model = new GRUPO_INVESTIGACION_Model($grupo_id, '', '', '', '', '', '');
                        $grupo = $grupo_model->rellenaDatos();

                        if ($grupo->getResponsableGrupo() == $usuario_autenticado->getUsuarioId()) {

                            $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
                            $espacio = $espacio_model->rellenaDatos();


                            if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
                                header('Location:../Controllers/Espacio_Controller.php?action=showall');
                            } else {
                                $respuesta = $espacio->DELETE();

                                if ($respuesta === true) {
                                    unlink($espacio->getRutaImagen());
                                    header('Location:../Controllers/Espacio_Controller.php?action=showall');
                                }
                            }


                        } else {
                            header('Location:../Controllers/Espacio_Controller.php?action=showall');
                        }

                        break;
                    case 'PAS':
                        if ($responsable_espacio->getNivelJerarquia() > $usuario_autenticado->getNivelJerarquia()) {

                            $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
                            $espacio = $espacio_model->rellenaDatos();


                            if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
                                header('Location:../Controllers/Espacio_Controller.php?action=showall');
                            } else {
                                $respuesta = $espacio->DELETE();

                                if ($respuesta === true) {
                                    unlink($espacio->getRutaImagen());
                                    header('Location:../Controllers/Espacio_Controller.php?action=showall');
                                }
                            }


                        } else {
                            header('Location:../Controllers/Espacio_Controller.php?action=showall');
                        }
                        break;
                    case 'COMUN':
                        if ($usuario_autenticado->getNombrePuesto() == 'Conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserje'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserje') {

                            $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
                            $espacio = $espacio_model->rellenaDatos();


                            if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
                                header('Location:../Controllers/Espacio_Controller.php?action=showall');
                            } else {
                                $respuesta = $espacio->DELETE();

                                if ($respuesta === true) {
                                    unlink($espacio->getRutaImagen());
                                    header('Location:../Controllers/Espacio_Controller.php?action=showall');
                                }
                            }


                        } else {
                            header('Location:../Controllers/Espacio_Controller.php?action=showall');
                        }
                        break;
                    default:
                        header('Location:../Controllers/Espacio_Controller.php?action=showall');
                        break;
                }

                header('Location:../Controllers/Espacio_Controller.php?action=showall');
            }

        }

    }

}

function comprobarPermisoBorrado($espacio_id, $login_usuario, $num_pag)
{
    //SHOWALL:
    $espacio_model = new ESPACIO_Model('', '', '', '', '', '', '');
    $allEspacios = $espacio_model->SHOWALL();

    $num_pags = ceil(count($allEspacios) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag - 1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allEspacios = array_slice($allEspacios, $inicio, $final);

    $nombreEdificios = [];
    $nombresResponsables = [];

    foreach ($allEspacios as $e) {
        $edificio_model = new EDIFICIO_Model($e->getEdificioEsp(), '', '', '', '', '');
        $nombreEdificios[$e->getEdificioEsp()] = $edificio_model->getNombreById();


        $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($e->getEspacioId(), '', '', '', '', '');
        $responsable_id = $solicitud_model->buscarResponsable();
        if ($responsable_id != 'Sin responsable') {
            $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
            $aux = $usuario_model->getNombreApellidosById();
            if ($aux == 'No existe el usuario en la BD') {
                $nombresResponsables[$e->getEspacioId()] = 'Sin responsable';
            } else {
                $nombresResponsables[$e->getEspacioId()] = $aux;
            }
        }
    }

    //COMRPOBACION DE SI EL USUARIO TIENE LOS PERMISOS PARA PODER REALIZAR EL BORRADO DEL ESPACIO:
    $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    //SI NO EXISTE EL ESPACIO REEDIRIGIR A LA PÁGINA PRINCIPAL
    if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
        new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags, 'No aceptado', $espacio_id);
    } //EN CASO CONTRARIO COMPROBAR SI TIENE PERMISOS PARA PODER REALIZAR EL BORRADO
    else {
        //UN USUARIO CON EL ROL DE ADMINISTRADOR SIEMPRE TIENE PERMISOS PARA REALIZAR EL BORRADO
        if ($_SESSION['rol'] == "ADMIN") {
            $borrado = 'Pendiente de confirmacion';
            new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags, $borrado, $espacio_id);
        } //EN CASO CONTARIO COMPROBAR SI EL QUE INTENTA ELIMINAR ES EL RESPONSABLE DEL CENTRO, DEPARTAMENTO, GRUPO DE INVESTIGACIÓN, TIENE MAYOR PUESTO O ES CONSERJERIA
        else {
            $categoria_espacio = $espacio->getCategoriaEsp();

            //Buscar quien es el responsable del espacio:
            $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
            $responsable_id = $solicitud_model->buscarResponsable();

            if ($responsable_id == 'Sin responsable' || $responsable_id == NULL) {
                new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags, 'No aceptado', $espacio_id);
            } else {
                $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $responsable_espacio = $usuario_model->rellenaDatosById();

                //Buscar usuario logueado:
                $usuario_model = new USUARIO_Model('', $login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $usuario_autenticado = $usuario_model->rellenaDatos();

                switch ($categoria_espacio) {
                    case 'DOCENCIA':
                        //Comprobar el departamento:
                        $departamento_id = $responsable_espacio->getDepartUsuario();

                        $departamento_model = new DEPARTAMENTO_Models($departamento_id, '', '', '', '', '', '', '');
                        $departamento = $departamento_model->rellenaDatos();

                        if ($departamento->getResponsableDepart() == $usuario_autenticado->getUsuarioId()) {
                            $borrado = 'Pendiente de confirmacion';
                        } else {
                            $borrado = 'No aceptado';
                        }
                        break;
                    case 'INVESTIGACION':
                        //Comprobar grupo de investigación
                        $grupo_id = $responsable_espacio->getGrupoUsuario();

                        $grupo_model = new GRUPO_INVESTIGACION_Model($grupo_id, '', '', '', '', '', '');
                        $grupo = $grupo_model->rellenaDatos();

                        if ($grupo->getResponsableGrupo() == $usuario_autenticado->getUsuarioId()) {
                            $borrado = 'Pendiente de confirmacion';
                        } else {
                            $borrado = 'No aceptado';
                        }

                        break;
                    case 'PAS':
                        if ($responsable_espacio->getNivelJerarquia() > $usuario_autenticado->getNivelJerarquia()) {
                            $borrado = 'Pendiente de confirmacion';
                        } else {
                            $borrado = 'No aceptado';
                        }
                        break;
                    case 'COMUN':
                        if ($usuario_autenticado->getNombrePuesto() == 'Conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserje'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserje') {
                            $borrado = 'Pendiente de confirmacion';
                        } else {
                            $borrado = 'No aceptado';
                        }
                        break;
                    default:
                        $borrado = 'No aceptado';
                        break;
                }

                new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags, $borrado, $espacio_id);
            }

        }

    }

}

function verHistorial($espacio_id, $nombre_espacio, $num_pag)
{
    $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
    $allResponsables = $solicitud_model->SHOWALL();

    $num_pags = ceil(count($allResponsables) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag - 1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $responsables = array_slice($allResponsables, $inicio, $final);

    $nombresResponsables = [];
    foreach ($responsables as $responsable) {
        //Nombre y Apellidos del responsable
        $usuario_model = new USUARIO_Model($responsable->getUsuarioId(), '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        $aux = $usuario_model->getNombreApellidosById();
        if ($aux == 'No existe el usuario en la BD') {
            $nombresResponsables[$responsable->getUsuarioId()] = 'Sin responsable';
        } else {
            $nombresResponsables[$responsable->getUsuarioId()] = $aux;
        }
    }


    foreach ($responsables as $responsable) {
        $fecha_inicio = explode("-", $responsable->getFechaInicio());
        $responsable->setFechaInicio($fecha_inicio[2] . "/" . $fecha_inicio[1] . "/" . $fecha_inicio[0]);

        $fecha_fin = explode("-", $responsable->getFechaFin());
        $responsable->setFechaFin($fecha_fin[2] . "/" . $fecha_fin[1] . "/" . $fecha_fin[0]);
    }

    new ESPACIO_HISTORIAL_View($espacio_id, $nombre_espacio, $responsables, $num_pag, $nombresResponsables);
}

function showcurrent($espacio_id)
{
    //Datos del espacio
    $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    //Nombre Responsable
    $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
    $responsable_id = $solicitud_model->buscarResponsable();
    $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $aux = $usuario_model->getNombreApellidosById();

    $nombresResponsable = "";
    if ($aux == 'No existe el usuario en la BD') {
        $nombresResponsable = 'Sin responsable';
    } else {
        $nombresResponsable = $aux;
    }


    //Nombre edificio
    $edificio_model = new EDIFICIO_Model($espacio->getEdificioEsp(), '', '', '', '', '');
    $edificio = $edificio_model->rellenaDatos();
    $nombreEdificioYPlanta = $edificio->getNombreEdificio() . ', planta ' . $espacio->getPlantaEsp();


    //Nombre agrupación edificios
    $agrupacion_model = new AGRUPACION_Model($edificio->getAgrup_edificio(), '', '');
    $agrupacion = $agrupacion_model->rellenaDatos();

    if($agrupacion == 'Error'){
        $nombreAgrupacion = '-';
    }
    else{
        $nombreAgrupacion = $agrupacion_model->getNombreAgrup();
    }



    //Información afiliación del responsable
    $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
    $usuario = $usuario_model->rellenaDatosById();

    if ($usuario == 'Error inesperado al intentar cumplir su solicitud de consulta') {
        $info_afiliacion = "-";
    } else if ($usuario->getAfiliacion() == "DOCENTE") {

        $centro_model = new CENTRO_Model($usuario->getCentroUsuario(), '', '');
        $centro = $centro_model->rellenaDatos();

        if ($centro == 'Error inesperado al intentar cumplir su solicitud de consulta'){
            $info_afiliacion = '-';
        }
        else{
            $departamento_model = new DEPARTAMENTO_Models($usuario->getDepartUsuario(), '', '', '', '', '', '', '');
            $departamento = $departamento_model->rellenaDatos();

            if($departamento == 'Error'){
                $info_afiliacion = '-';
            }
            else{
                $info_afiliacion = $departamento->getNombreDepartamento() . ", " . $centro->getNombreCentro();
            }

        }



    } else if ($usuario->getAfiliacion() == "INVESTIGADOR") {

        $grupo_investigacion_model = new GRUPO_INVESTIGACION_Model($usuario->getGrupoUsuario(), '', '', '', '', '', '');
        $grupo = $grupo_investigacion_model->rellenaDatos();

        if($grupo == 'Error inesperado al intentar cumplir su solicitud de consulta'){
            $info_afiliacion = '-';
        }
        else{
            $info_afiliacion = $grupo->getNombreGrupo();
        }

    } else if ($usuario->getAfiliacion() == "ADMINISTRACION") {

        $info_afiliacion = $usuario->getNivelJerarquia() . ", " . $usuario->getNombrePuesto();

    } else {
        $info_afiliacion = "-";
    }


    new ESPACIO_SHOWCURRENT_View($espacio, $nombresResponsable, $nombreEdificioYPlanta, $nombreAgrupacion, $info_afiliacion);
}

function showall($num_pag)
{

    list($allEspacios, $num_pags, $nombreEdificios, $nombresResponsables) = preparar_showall($num_pag);

    new ESPACIO_SHOWALL_View($allEspacios, $nombreEdificios, $nombresResponsables, $num_pags, '', 0);
}

/**
 * @param $num_pag
 * @return array
 */
function preparar_showall($num_pag)
{
    $espacio_model = new ESPACIO_Model('', '', '', '', '', '', '');
    $allEspacios = $espacio_model->SHOWALL();

    $num_pags = ceil(count($allEspacios) / TAM_PAG);
    $num_pag = $num_pag > $num_pags || $num_pag <= 0 ? 1 : $num_pag;
    $inicio = ($num_pag - 1) * TAM_PAG;
    $final = $inicio + TAM_PAG;

    $allEspacios = array_slice($allEspacios, $inicio, $final);

    $nombreEdificios = [];
    $nombresResponsables = [];

    foreach ($allEspacios as $espacio) {
        $edificio_model = new EDIFICIO_Model($espacio->getEdificioEsp(), '', '', '', '', '');
        $nombreEdificios[$espacio->getEdificioEsp()] = $edificio_model->getNombreById();


        $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio->getEspacioId(), '', '', '', '', '');
        $responsable_id = $solicitud_model->buscarResponsable();
        if ($responsable_id != 'Sin responsable') {
            $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
            $aux = $usuario_model->getNombreApellidosById();
            if ($aux == 'No existe el usuario en la BD') {
                $nombresResponsables[$espacio->getEspacioId()] = 'Sin responsable';
            } else {
                $nombresResponsables[$espacio->getEspacioId()] = $aux;
            }
        }
    }
    return array($allEspacios, $num_pags, $nombreEdificios, $nombresResponsables);
}


function tienePermisos($login_usuario, $espacio_id){
    //COMRPOBACION DE SI EL USUARIO TIENE LOS PERMISOS PARA PODER REALIZAR EL BORRADO DEL ESPACIO:
    $espacio_model = new ESPACIO_Model($espacio_id, '', '', '', '', '', '');
    $espacio = $espacio_model->rellenaDatos();

    //SI NO EXISTE EL ESPACIO REEDIRIGIR A LA PÁGINA PRINCIPAL
    if ($espacio == 'Error inesperado al intentar cumplir su solicitud de consulta') {
        return false;
    } //EN CASO CONTRARIO COMPROBAR SI TIENE PERMISOS PARA PODER REALIZAR EL BORRADO
    else {
        //UN USUARIO CON EL ROL DE ADMINISTRADOR SIEMPRE TIENE PERMISOS PARA REALIZAR EL BORRADO
        if ($_SESSION['rol'] == "ADMIN") {
            return true;
        } //EN CASO CONTARIO COMPROBAR SI EL QUE INTENTA ELIMINAR ES EL RESPONSABLE DEL CENTRO, DEPARTAMENTO, GRUPO DE INVESTIGACIÓN, TIENE MAYOR PUESTO O ES CONSERJERIA
        else {
            $categoria_espacio = $espacio->getCategoriaEsp();

            //Buscar quien es el responsable del espacio:
            $solicitud_model = new SOLICITUD_RESPONSABILIDAD_Model($espacio_id, '', '', '', '', '');
            $responsable_id = $solicitud_model->buscarResponsable();

            if ($responsable_id == 'Sin responsable' || $responsable_id == NULL) {
                return false;
            } else {
                $usuario_model = new USUARIO_Model($responsable_id, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $responsable_espacio = $usuario_model->rellenaDatosById();

                //Buscar usuario logueado:
                $usuario_model = new USUARIO_Model('', $login_usuario, '', '', '', '', '', '', '', '', '', '', '', '', '', '');
                $usuario_autenticado = $usuario_model->rellenaDatos();

                switch ($categoria_espacio) {
                    case 'DOCENCIA':
                        //Comprobar el departamento:
                        if($usuario_autenticado->getAfiliacion() != 'DOCENTE'){
                            return false;
                        }
                        $departamento_id = $responsable_espacio->getDepartUsuario();
                        $departamento_model = new DEPARTAMENTO_Models($departamento_id, '', '', '', '', '', '', '');
                        $departamento = $departamento_model->rellenaDatos();

                        if ($departamento->getResponsableDepart() == $usuario_autenticado->getUsuarioId()) {
                            return true;
                        } else {
                            return false;
                        }
                    case 'INVESTIGACION':
                        //Comprobar grupo de investigación
                        $grupo_id = $responsable_espacio->getGrupoUsuario();

                        $grupo_model = new GRUPO_INVESTIGACION_Model($grupo_id, '', '', '', '', '', '');
                        $grupo = $grupo_model->rellenaDatos();

                        if ($grupo->getResponsableGrupo() == $usuario_autenticado->getUsuarioId()) {
                            return true;
                        } else {
                            return false;
                        }
                    case 'PAS':
                        if ($responsable_espacio->getNivelJerarquia() > $usuario_autenticado->getNivelJerarquia()) {
                            return true;
                        } else {
                            return false;
                        }
                    case 'COMUN':
                        if ($usuario_autenticado->getNombrePuesto() == 'Conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjería'
                            || $usuario_autenticado->getNombrePuesto() == 'conserjeria'
                            || $usuario_autenticado->getNombrePuesto() == 'conserje'
                            || $usuario_autenticado->getNombrePuesto() == 'Conserje') {
                            return true;
                        } else {
                            return false;
                        }
                    default:
                        return false;
                }
            }

        }
    }
}

?>