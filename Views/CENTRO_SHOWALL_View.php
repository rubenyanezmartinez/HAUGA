<?php
class CENTRO_SHOWALL_View{

    var $arrayCentros;
    var $numPag;
    var $nombreEdificios;

    function __construct($arrayCentros, $nombreEdificios , $numPag)
    {
        $this->arrayCentros = $arrayCentros;
        $this->numPag = $numPag;
        $this->nombreEdificios = $nombreEdificios;

        $this->render();
    }

    function render(){
        include '../Views/Header.php';
        ?>
        <script>
            $(document).on('click', '.eliminar', function () {
                var descr = $(this).attr('data-enlace');
                var enlace = "../Controllers/Centro_Controller.php?action=delete&centro_id="+descr;
                console.log(descr)
                $('#exampleModal a[name=eliminar]').prop('href', enlace);

                // aquí es cuando tienes que mirar la documentación de tu framework
                $('#exampleModal').modal('show'); // o similar

            });
        </script>
        <div class="container">
            <div class="row align-self-center">
                <div class="col text-left">
                    <?php
                    include_once '../Functions/Authentication.php';
                    include_once '../Functions/esAdministrador.php';
                    if(IsAuthenticated() && esAdministrador()){ ?>
                        <a class="btn btn-primary" style="background-color: #073349;" href="../Controllers/Centro_Controller.php?action=add">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Centro
                        </a>
                    <?php } ?>
                </div>
                <div class="col align-self-center">
                    <h2 class="text-center textoAzul">Centros</h2>
                </div>
                <div class="col text-right">

                </div>
            </div>
            <hr>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Edificio</th>
                        <th style="width: 10%" scope="col">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->arrayCentros as $centro){ ?>

                        <tr>
                            <th scope="row"><?=$centro->getNombreCentro()?></th>
                            <th><?=$this->nombreEdificios[$centro->getCentroId()]?></th>
                            <th style="text-align: center">

                                <?php if(IsAuthenticated() && esAdministrador()) {?>
                                    <a class="eliminar" data-enlace="<?=$centro->getCentroId()?>">
                                        <svg style="color: #ff0000" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </th>
                        </tr>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar centro</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Está seguro de qué desea eliminar el centro?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <a name="eliminar" href=""><button type="button" class="btn btn-danger">Eliminar</button></a>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        <?php
    }
}