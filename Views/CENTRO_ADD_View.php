<?php
class EDIFICIO_ADD_View{

var $respuesta;

//Constructor de la clase
function __construct($respuesta=''){
    $this->respuesta = $respuesta;
    $this ->render();
}

function render(){
include '../Views/Header.php'; //Incluye la cabecera
?>
    <!doctype html>
    <html lang="es">

    <div class="container">
        <div class="row">
            <div class="col-12 align-self-center">
                <form action="../Controllers/Centro_Controller.php?action=add" method="post" id="addCentroForm">
                    <h2 class="text-center textoAzul mb-4">Crear Centro</h2>
                    <hr>
                    
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
                            <input type="text" class="form-control" id="nombre_centro" name="nombre_centro" placeholder="Nombre Centro"  size="70" maxlength="70" value="">
                        </div>

                    <!-- Segunda fila -->
                    <div class="row">

                        <div class="col-md-6 input-group mb-2" style="margin-bottom: 1rem!important;">
                            <div class=" input-group-prepend">
                                <div class="input-group-text" style="background-color: #073349;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="white" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                    </svg>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="edificio_centro" name="edificio_centro" placeholder="Edificio del centro"  size="70" maxlength="70" value="">
                        </div>

                    <!-- Fila final de botones -->
                    <div class ="row">
                        <div class="col-md-6  mb-2" style="margin-bottom: 1rem!important;">
                            <button id="botonAtrasAddCentro" type='submit' name='action' value='atras' class="btn btn-light mr-4">
                                Atrás
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-arrow-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                            </button>

                            <button id="botonAddCentro" type='submit' name='action' value='addCentro' class="btn btn-success">
                                Crear Centro
                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg>
                            </button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    }
}
?>