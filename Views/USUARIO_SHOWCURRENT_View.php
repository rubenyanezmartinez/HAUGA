<?php
class USUARIO_SHOWCURRENT_View{


    function __construct($vectorUsuario){
        $this->render($vectorUsuario);
    }


    function render($vectorUsuario){

    include '../Views/Header.php'; //Incluye la cabecera

    ?>


        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <h2 class="textoAzul">Vista en detalle de <?php echo $vectorUsuario["login"]; ?></h2>
                </div>
            </div>

            <hr>

            <ul>
                <div class="row">
                    <div class="col text-left">
                        <li><b>Nombre: </b><?php echo $vectorUsuario["nombre"];?></li>
                    </div>
                </div>


                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Apellidos: </b><?php echo $vectorUsuario["apellidos"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Fecha de nacimiento: </b><?php echo $vectorUsuario["fecha_nacimiento"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Correo electrónico: </b><?php echo $vectorUsuario["email_usuario"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Teléfono: </b><?php echo $vectorUsuario["telef_usuario"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>DNI: </b><?php echo $vectorUsuario["dni"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Rol: </b><?php echo $vectorUsuario["rol"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Afiliación: </b><?php echo $vectorUsuario["afiliacion"];?></li>
                    </div>
                </div>

                <div class="row" style="padding-top: 0.5%;">
                    <div class="col text-left">
                        <li><b>Información sobre afiliación: </b><?php echo $vectorUsuario["info_afiliacion"];?></li>
                    </div>
                </div>

            </ul>

            <div class="row">
                <div class="col text-right">
                    <a id="botonAtras" href="../Controllers/User_Controller.php?action=showall" class="btn btn-light">
                        Atrás
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>


        <?php
        //Incluye el pie de página.
        include '../Views/Footer.php';
    }

}


?>