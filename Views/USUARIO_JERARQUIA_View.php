<?php
class USUARIO_JERARQUIA_View{


    function __construct(){
        $this->render();
    }


    function render(){

        include '../Views/Header.php'; //Incluye la cabecera

        ?>
        <div class="container">

            <div class="row">
                <div class="col text-center">
                    <h2 class="textoAzul">Jerarquía de administración</h2>
                </div>
            </div>

            <hr>




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