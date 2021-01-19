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
                        <img src="../Views/img/foto_portada_1.PNG" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../Views/img/foto_portada_2.PNG" class="d-block w-100">
                    </div>
                    <div class="carousel-item">
                        <img src="../Views/img/foto_portada_3.PNG" class="d-block w-100">
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
            include '../Views/INCIDENCIA_ADD_View.php';
        </div>

    </div>

</div>

