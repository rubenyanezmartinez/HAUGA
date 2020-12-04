<?php
class USUARIO_JERARQUIA_View{

    var $usuarios;
    var $niveles;

    function __construct($usuarios, $niveles){
        $this->usuarios = $usuarios;
        $this->niveles = $niveles;
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

            <div class="row" style="padding-bottom: 1%">
                <div class="col">
                    <div class="accordion" id="accordionExample">

                    <?php foreach ($this->niveles as $nivel) { ?>

                        <div class="card">
                            <div class="card-header" id="heading<?php echo $nivel; ?>" style="background-color: #073349">
                                <h5>
                                    <button style="color: white; font-size: large" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $nivel; ?>" aria-expanded="true" aria-controls="collapse<?php echo $nivel; ?>">
                                        Nivel <?php echo $nivel; ?>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $nivel; ?>" class="collapse" aria-labelledby="heading<?php echo $nivel; ?>" data-parent="#accordionExample">
                                <div class="card-body">
                                    <?php foreach ($this->usuarios[$nivel] as $usuario) {
                                        echo '<b>'.$usuario->getNombrePuesto().'</b> - '.$usuario->getApellidos().', '.$usuario->getNombre().'<br>';
                                    } ?>
                                </div>
                            </div>
                        </div>

                    <?php } ?>

                    </div>
                </div>
            </div>



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