<?php
class GRUPOINVESTIGACION_SHOWCURRENT_View{
    var $grupoInvestigacion;
    var $responsableLogin;

    function __construct($grupoInvestigacion, $responsableLogin)
    {
        $this->grupoInvestigacion = $grupoInvestigacion;
        $this->responsableLogin = $responsableLogin;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>

        <div class="container">

            <?php if ($this->grupoInvestigacion== null){ ?>
                <div class="alert alert-danger">El grupo de investigación al que está intentando acceder no existe.</div>
            <?php } else { ?>

                <div class="row">
                    <div class="col text-center">
                        <h2 class="textoAzul">Vista en detalle del grupo de investigación <?=$this->grupoInvestigacion->getNombreGrupo() ?></h2>
                    </div>
                </div>

                <hr>

                <ul>
                    <div class="row">
                        <div class="col text-left">
                            <li><b>Nombre: </b><?=$this->grupoInvestigacion->getNombreGrupo() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Teléfono: </b><?=$this->grupoInvestigacion->getTelefGrupo() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Líneas de investigación: </b><?=$this->grupoInvestigacion->getLineasInvestigacion() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Área de Conocimiento: </b><?=$this->grupoInvestigacion->getAreaConocGrupo() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Correo electrónico </b><?=$this->grupoInvestigacion->getEmailGrupo() ?></li>
                        </div>
                    </div>

                    <div class="row" style="padding-top: 0.5%;">
                        <div class="col text-left">
                            <li><b>Responsable: </b><?=$this->responsableLogin ?></li>
                        </div>
                    </div>

                </ul>
            <div class="row">
                <div class="col text-right">
                    <a id="botonAtrasCurrentUser" href="../Controllers/GrupoInvestigacion_Controller.php?action=showall" class="btn btn-light">
                        Atrás
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                    </a>
                </div>
            </div>

            </div>
        <?php } ?>
<?php
    }
}