<?php
class AGRUPACION_SHOWALL_View{

    var $arrayAgrupaciones;
    var $num_pag;

    function __construct($arrayAgrupaciones, $num_pag)
    {
        $this->arrayAgrupaciones = $arrayAgrupaciones;
        $this->num_pag = $num_pag;
        $this->render();
    }

    function render(){
        include '../Views/Header.php';

        ?>
        <script>
            $(document).on('click', '.eliminar', function () {
                var descr = $(this).attr('data-enlace');
                var enlace = "../Controllers/AGRUPACION_Controller.php?action=delete&agrup_id="+descr;
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
                        <a class="btn btn-primary" style="background-color: #073349;" href="../Controllers/AGRUPACION_Controller.php?action=add">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nueva Agrupación
                        </a>
                    <?php } ?>
                </div>
                <div class="col align-self-center">
                    <h2 class="text-center textoAzul">Agrupaciones de Edificios</h2>
                </div>
                <div class="col text-right">

                </div>
            </div>
            <hr>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Nombre de la Agrupación</th>
                        <th scope="col">Ubicación de la Agrupación</th>
                        <th scope="col" width="10%">Nº edificios</th>
                        <th style="width: 10%" scope="col">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->arrayAgrupaciones as $agrup){

                        echo '<tr>';
                        echo '<th scope="row">' . $agrup['nombre_agrup'] . '</th>';
                        echo '<th>' . $agrup['ubicacion_agrup'] . '</th>';
                        echo '<th style="text-align: center">' . $agrup['num_edificios'] . '</th>';
                        echo '<th style="text-align: center">
                                        <a href="../Controllers/AGRUPACION_Controller.php?action=showcurrent&agrup_id='.$agrup['agrup_id'].'">
                                            <svg style="color: green" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                            </svg>
                                        </a>';
                        include_once '../Functions/Authentication.php';
                        include_once '../Functions/esAdministrador.php';
                        if(IsAuthenticated() && esAdministrador())

                            /*
                             *
                             *                                     <a class="eliminar" data-enlace="<?=$this->usuarios[$i]->getLogin()?>">
                                    <svg style="color: red" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                         class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    </a>*/
?>
                                 <a class="eliminar" data-enlace="<?=$agrup['agrup_id']?>">
                                    <?php
                                     echo      ' <svg style="color: #ff0000" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>';

                        echo '<a href="#">
                                            <svg style="color: #073349;" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-building" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                              <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694L1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                              <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                            </svg>
                                        </a>';
                        echo        '</th>';
                        echo '</tr>';

                        ?>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Eliminar agrupación de edificio</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                        ¿Está seguro de qué desea eliminar la agrupación?
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

            <div class="row">
                <div class="col">
                    <nav aria-label="paginacion">
                        <ul class="pagination justify-content-end">
                            <?php for ($i = 1; $i < $this->num_pag + 1; $i++){
                                echo '<li class="page-item"><a class="page-link" style="background-color: #073349; color: white" href="../Controllers/AGRUPACION_Controller.php?action=showall&num_pag='.$i.'">'.$i.'</a></li>';
                            } ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
<?php
        include '../Views/Footer.php';
    }
}