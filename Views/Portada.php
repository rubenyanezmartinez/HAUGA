<div class="container-fluid">
    <div class="row">

        <div class="col">
            <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/foto_portada_1.PNG" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="img/foto_portada_2.PNG" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="img/foto_portada_3.PNG" class="d-block w-100">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div class="col">
            <form>
                <h5 class="text-center textoAzul">Crear incidencia</h5>
                <?php if (IsAuthenticated()) {?>
                    <div class="form-group">

                    </div>
                <?php } else {?>
                    <div class="form-group">
                        <input type="text" class="form-control" id="nombreYApellidos" placeholder="Nombre y Apellidos">
                    </div>
                <?php } ?>
                <div class="form-group">
                    <select class="form-control" id="agrupacion">
                        <option disabled selected>Selecciona una agrupación</option>
                        <option>Campos de Ourense</option>
                        <option>Campus de Vigo</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="edificio">
                        <option disabled selected>Selecciona un edificio</option>
                        <option>Politécnico</option>
                        <option>Educación</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="espacio">
                        <option disabled selected>Selecciona un espacio</option>
                        <option>2.1</option>
                        <option>2.2</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="textoIncidencia" rows="3" placeholder="Escriba el motivo de la indicencia ..."></textarea>
                </div>
            </form>

        </div>

    </div>

</div>

