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
        <!-- Fila con las cabeceras de la tabla -->
        <section>
            <!-- Tabla showall -->
        </section>
        <?php
        //Incluye el pie de página.
        include '../Views/Footer.php';
    }

}


?>
