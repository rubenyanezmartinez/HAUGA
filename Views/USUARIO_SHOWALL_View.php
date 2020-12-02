<?php
class USUARIO_SHOWALL_View{

    //Constructor de la clase, recibe un array de usuarios que muestra por pantalla en forma de tabla
    function __construct($arrayUsuarios){
        $this->render($arrayUsuarios);
    }

    //Funcion que crea la tabla SHOWALL
    function render($arrayUsuarios){

        include '../Views/Header.php'; //Incluye la cabecera

        ?>

        <div class="container">

            <!-- Fila con las cabeceras de la tabla -->
            <div class="row align-self-center">
                <div class="col text-left">
                    <a class="btn btn-primary" style="background-color: #073349;" href="../Controllers/User_Controller.php?action=add">
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Nuevo Usuario
                    </a>
                </div>

                <div class="col align-self-center">
                    <h2 class="text-center textoAzul">Usuarios</h2>
                </div>

                <div class="col text-right">
                    <a class="btn btn-primary" style="background-color: #073349;" href="../Controllers/User_Controller.php?action=add">
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-diagram-3" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0V8h-5v.5a.5.5 0 0 1-1 0v-1A.5.5 0 0 1 2 7h5.5V6A1.5 1.5 0 0 1 6 4.5v-1zM8.5 5a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1zM0 11.5A1.5 1.5 0 0 1 1.5 10h1A1.5 1.5 0 0 1 4 11.5v1A1.5 1.5 0 0 1 2.5 14h-1A1.5 1.5 0 0 1 0 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5A1.5 1.5 0 0 1 7.5 10h1a1.5 1.5 0 0 1 1.5 1.5v1A1.5 1.5 0 0 1 8.5 14h-1A1.5 1.5 0 0 1 6 12.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm4.5.5a1.5 1.5 0 0 1 1.5-1.5h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                        </svg>
                        Jerarquía Administración
                    </a>
                </div>
            </div>

            <hr>
            <!-- Tabla showall -->
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Usuario</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Correo Electrónico</th>
                        <th scope="col">Afiliación</th>
                        <th scope="col">Información de Afiliación</th>
                        <th scope="col">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php

                        foreach($arrayUsuarios as $usuario){

                            echo '<tr>';
                            echo '<th scope="row">'.$usuario->login.'</th>';
                            echo '<th>'.$usuario->nombre.'</th>';
                            echo '<th>'.$usuario->apellidos.'</th>';
                            echo '<th>'.$usuario->dni.'</th>';
                            echo '<th>'.$usuario->email_usuario.'</th>';
                            echo '<th>'.$usuario->afiliacion.'</th>';
                            if($usuario->afiliacion == 'DOCENTE'){
                                echo '<th>'.$usuario->depart_usuario.', '.$usuario->centro_usuario.'</th>';
                            }
                            else if ($usuario->afiliacion == 'INVESTIGADOR'){
                                echo '<th>.$usuario->grupo_usuario.</th>';
                            }
                            else if ($usuario->afiliacion == 'ADMINISTRACION'){
                                echo '<th>'.$usuario->nivel_jerarquia.', '.$usuario->nombre_puesto.'</th>';
                            }
                            else{
                                echo '<th></th>';
                            }
                            echo '<th>
                                        <a href="../Controllers/User_Controller.php?action=showcurrent">
                                            <svg style="color: green" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                            </svg>
                                        </a>
                                        <a href="../Controllers/User_Controller.php?action=edit">
                                            <svg style="color: yellow" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                        </button>
                                        <a href="../Controllers/User_Controller.php?action=delete">
                                            <svg style="color: red" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                </th>';
                            echo '</tr>';

                        }

                    ?>


                    </tbody>
                </table>
            </div>

        </div>
        <?php
        //Incluye el pie de página.
        include '../Views/Footer.php';
    }

}


?>
