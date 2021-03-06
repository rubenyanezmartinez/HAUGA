<?php


class EDIFICIO_SHOWALL_View
{
    var $arrayEdificios;
    var $agrupacionEdificios;

    function __construct($arrayEdificios, $agrupacionEdificios, $num_pag, $borrado)
    {
        $this->arrayEdificios = $arrayEdificios;
        $this->agrupacionEdificios = $agrupacionEdificios;
        $this->num_pag = $num_pag;
        $this->showall();

    }

    function showall(){
        include '../Views/Header.php';

        ?>
        <script>
            $(document).on('click', '.eliminar', function () {
                var descr = $(this).attr('data-enlace');
                var enlace = "../Controllers/Edificio_Controller.php?action=delete&edificio_id="+descr;
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
                    if(IsAuthenticated() && $_SESSION['rol']=='ADMIN'){ ?>
                        <a class="btn btn-primary" style="background-color: #073349;" href="../Controllers/Edificio_Controller.php?action=add">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                            Nuevo Edificio
                        </a>
                    <?php } ?>
                </div>
                <div class="col align-self-center">
                    <h2 class="text-center textoAzul">Edificios</h2>
                </div>
                <div class="col text-right">

                </div>
            </div>
            <?php 
                if(sizeof($this->arrayEdificios) == 0){
                    echo "No existen edificios para esta agrupación";
                }
                else{
            ?>
            <hr>
            <div class="row">
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center" style="color: white;background-color: #073349;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Agrupación</th>
                        <th scope="col">Teléfono</th>
                        <th style="width: 10%" scope="col">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($this->arrayEdificios as $edificio){?>

                        <tr>
                            <th scope="row"><?=$edificio['nombre_edif']?></th>
                            <th><?=$this->agrupacionEdificios['nombre_agrup']?></th>
                            <th><?=$edificio['telef_edif']?></th>
                            <th style="text-align: center">
                                <a href="../Controllers/Edificio_Controller.php?action=showcurrent&edificio_id=<?=$edificio['edificio_id']?>&agrupacion_id=<?=$this->agrupacionEdificios['agrup_id']?>">
                                    <svg style="color: green" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    </svg>
                                </a>

                                <?php if(IsAuthenticated() && $_SESSION['rol']=='ADMIN') {?>
                                    <a href="../Controllers/Edificio_Controller.php?action=edit&edificio_id=<?=$edificio['edificio_id']?>">
                                        <svg style="color: yellow" width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                             class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </a>

                                    <a class="eliminar" data-enlace="<?=$edificio['edificio_id']?>">
                                        <svg style="color: #ff0000" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                <?php } ?>
                            </th>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
                }
            ?>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Eliminar edificio</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ¿Está seguro de qué desea eliminar el edificio?
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
            <div class="row">
                <div class="col">
                    <nav aria-label="paginacion">
                        <ul class="pagination justify-content-end">
                            <?php for ($i = 1; $i < $this->num_pag + 1; $i++){
                                echo '<li class="page-item"><a class="page-link" style="background-color: #073349; color: white" href="../Controllers/Edificio_Controller.php?action=showall&agrupacion_id='.$this->agrupacionEdificios['agrup_id'].'&num_pag='.$i.'">'.$i.'</a></li>';
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

?>