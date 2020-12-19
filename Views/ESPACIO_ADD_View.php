<?php

class ESPACIO_ADD_View{
    var $espacio;
    var $edificios;
    var $usuarios;

    function __construct($espacio, $edificios, $usuarios)
    {
        $this->espacio = $espacio;
        $this->edificios = $edificios;
        $this->usuarios = $usuarios;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>
        <div class="container">
            <div class="row">
                <!-- <div class="col-4"></div>-->
                <div class="col-12 align-self-center">
                    <form action="../Controllers/Espacio_Controller.php?action=add" method="post" id="addEspacioForm">
                        <h2 class="text-center textoAzul mb-4">Dar de Alta Espacio</h2>

                        <!-- Primera fila -->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <div class=" input-group-prepend">
                                    <div class="input-group-text" style="background-color: #073349;">
                                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-fonts" fill="white" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.258 3H3.747l-.082 2.46h.479c.26-1.544.758-1.783 2.693-1.845l.424-.013v7.827c0 .663-.144.82-1.3.923v.52h4.082v-.52c-1.162-.103-1.306-.26-1.306-.923V3.602l.43.013c1.935.062 2.434.301 2.694 1.846h.479L12.258 3z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="nombre_esp" name="nombre_esp" placeholder="Nombre Espacio" value="<?php echo($this->espacio->getNombreEsp())?>" size="70" maxlength="70">
                            </div>

                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color: #073349;">
                                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-eyeglasses" fill="white" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 6a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="number" class="form-control" id="area_conc_depart" name="area_conc_depart" placeholder="Área de Conocimiento" size="30" maxlength="30" value="<?php echo($this->espacio->getTarifaEsp())?>">
                            </div>

                        </div>

                        <!-- Segunda fila -->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <select class="form-control" id="categoria_esp" name="categoria_esp">
                                    <option value="" disabled <?= $this->espacio->getCategoriaEsp() == '' ? 'selected' : ''?>>Categoría</option>
                                    <option value="DOCENCIA" <?= $this->espacio->getCategoriaEsp() == 'DOCENCIA' ? 'selected' : ''?>>Docencia</option>
                                    <option value="INVESTIGACION" <?= $this->espacio->getCategoriaEsp() == 'INVESTIGACION' ? 'selected' : ''?>>Investigación</option>
                                    <option value="PAS" <?= $this->espacio->getCategoriaEsp() == 'PAS' ? 'selected' : ''?>>PAS</option>
                                    <option value="COMUN" <?= $this->espacio->getCategoriaEsp() == 'COMUN' ? 'selected' : ''?>>Común</option>
                                </select>
                            </div>

                            <div class="col-md-6 form-group" id="div_edificio_esp">
                                <select class="form-control" id="edificio_esp" name="edificio_esp">

                                    <option value="" disabled <?= $this->espacio->getEdificioEsp() == '' ? 'selected' : ''?>>Edificio</option>

                                    <?php
                                    foreach ($this->edificios as $edificio){
                                        if($edificio->edificio_id == $this->espacio->getEdificioEsp()){?>
                                            <option value="<?=$edificio->edificio_id?>" selected><?php echo $edificio->nombre_edif ?></option>
                                        <?php }else{?>
                                            <option value="<?=$edificio->edificio_id?>"><?php echo $edificio->nombre_edif ?></option>
                                        <?php }}?>
                                </select>
                            </div>
                        </div>

                        <!-- Tercera fila -->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                            </div>
                            (RESPONSABLE CHECK)
                        </div>

                        <?php if(false){ ?>
                            <div class="alert alert-danger"></div>
                        <?php } ?>

                        <div class ="row">
                            <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;">
                                <a id="botonAtrasAddEspacio" href="../Controllers/Espacio_Controller.php?action=showall" class="btn btn-light mr-4">
                                    Atrás
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </a>

                                <button id="botonAddEspacio" type='submit' name='action' value='addEspacio' class="btn btn-success">
                                    Crear Espacio
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </button>
                            </div>




                        </div>

                    </form>

                </div>
                <!--  <div class="col-4"></div>-->

            </div>

        </div>


        <?php
//Incluye el pie de página.
        include '../Views/Footer.php';
    }
}