<?php

class ESPACIO_SEARCH_View{
    var $centros;
    var $departamentos;
    var $grupos;
    var $responsables;
    var $agrupacion;
    var $edificios;

    function __construct($departamentos, $centros, $grupos, $responsables, $agrupacion, $edificios)
    {
        $this->centros = $centros;
        $this->departamentos = $departamentos;
        $this->grupos = $grupos;
        $this->responsables = $responsables;
        $this->agrupacion = $agrupacion;
        $this->edificios = $edificios;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>
        <script>
        $('select').selectpicker();
        </script>
        <div class="container">
            <div class="row">
                <!-- <div class="col-4"></div>-->

                <div class="col-12 align-self-center">
                    <form enctype="multipart/form-data" action="../Controllers/Espacio_Controller.php?action=search" method="post" id="searchEspacioForm">
                        <h2 class="text-center textoAzul mb-4">Buscar Espacio</h2>
                        <!-- Primera fila -->
                        <div class="row">
                            <div class="col-md-6 form-group" id="div_centro_espacio">
                                <select class=" form-control selectpicker " id="centro_espacio" name="centro_espacio" multiple>

                                    <option value="" selected disabled>Centro</option>

                                    <?php
                                    foreach ($this->centros as $centro){?>
                                        <option value="<?=$centro->getCentroId()?>" ><?= $centro->getNombreCentro() ?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="col-md-6 form-group" id="div_depart_espacio">
                                <select class=" form-control selectpicker" id="depart_espacio" name="depart_espacio" multiple>

                                    <option value="" disabled selected>Departamento</option>

                                    <?php
                                    foreach ($this->departamentos as $departamento){?>
                                            <option value="<?=$departamento->getDepartId()?>" ><?= $departamento->getNombreDepart() ?></option>
                                        <?php }?>
                                </select>
                            </div>
                        </div>

                        <!--Segunda fila-->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color: #073349;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                                            <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="area_conc_search"  name="area_conc_search" placeholder="Área de conocimiento" size="30" maxlength="30">
                            </div>

                            <div class="col-md-6 form-group" id="div_grupo_espacio">
                                <select class=" form-control selectpicker" id="grupo_espacio" name="grupo_espacio" multiple>

                                    <option value="" disabled selected>Grupo de investigación</option>

                                    <?php
                                    foreach ($this->grupos as $grupo){?>
                                        <option value="<?=$grupo->getGrupoId()?>"><?= $grupo->getNombreGrupo() ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>

                        <!--Tercera fila-->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color: #073349;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-chat-right-text" viewBox="0 0 16 16">
                                            <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="text" class="form-control" id="puesto_search"  name="puesto_search" placeholder="Puesto administrativo" size="60" maxlength="60">
                            </div>

                            <div class="col-md-6 form-group" id="div_responsable_espacio">
                                <select class=" form-control selectpicker" id="responsable_espacio" name="responsable_espacio" multiple>

                                    <option value="" disabled selected>Responsable</option>

                                    <?php
                                    foreach ($this->responsables as $responsable){?>
                                        <option value="<?=$responsable->getUsuarioId()?>"><?= $responsable->getNombre() ?></option>
                                    <?php }?>
                                </select>
                            </div>


                        </div>

                        <!--Cuarta fila-->
                        <div class="row">
                            <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" style="background-color: #073349;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-list-ol" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                                            <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
                                        </svg>
                                    </div>
                                </div>
                                <input type="number" class="form-control" id="nivel_search"  name="nivel_search" placeholder="Nivel Jerarquía">
                            </div>

                            <div class="col-md-6 form-group" id="div_agrupacion_espacio">
                                <select class=" form-control selectpicker" id="agrupacion_espacio" name="agrupacion_espacio" multiple>

                                    <option value="" disabled selected>Agrupación de edificios</option>

                                    <?php
                                    foreach ($this->agrupacion as $agrupacion){?>
                                        <option value="<?=$agrupacion->getAgrupId()?>"><?= $agrupacion->getNombreAgrup() ?></option>
                                    <?php }?>
                                </select>
                            </div>


                        </div>

                        <!--Cuarta fila-->
                        <div class="row">

                            <div class="col-md-6 form-group" id="div_edificio_espacio">
                                <select class=" form-control selectpicker" id="edificio_espacio" name="edificio_espacio" multiple>

                                    <option value="" disabled selected>Edificio</option>

                                    <?php
                                    foreach ($this->edificios as $edificio){?>
                                        <option value="<?=$edificio->getEdificioId()?>"><?= $edificio->getNombreEdificio() ?></option>
                                    <?php }?>
                                </select>
                            </div>


                        </div>


                        <div class ="row">
                            <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;">
                                <button id="botonSearchEspacio" type='submit' name='action' value='searchEspacio' class="btn btn-success" style="background-color: #073349; color: white;">
                                    Buscar Espacio
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;text-align: right">
                                <a id="botonAtrasSearchEspacio" href="../Controllers/Espacio_Controller.php?action=search" class="btn btn-light">
                                    Atrás
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                    </svg>
                                </a>
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