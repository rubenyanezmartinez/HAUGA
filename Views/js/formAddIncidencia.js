function incidenciaCambiarAgrup(selectAgrup){
    var agrupId = $(selectAgrup).val();

    var allOption = $("#edificio option.edificio");

    allOption.each(function(index){
        $(this).attr('hidden', 'hidden');
    });

    var optionEdificios = $("#edificio option.agrupacion-" + agrupId);

    optionEdificios.each(function(index){
        $(this).removeAttr('hidden');
    });

    var selectEdificio = $('#edificio');
    $(selectEdificio).val('').trigger('change');
}

function incidenciaCambiarEdificio(selectEdificio){
    var edificioId = $(selectEdificio).val();

    var allOption = $("#espacio option.espacio");
    allOption.each(function(index){
        $(this).attr('hidden', 'hidden');
    });

    var optionEspacios = $("#espacio option.edificio-" + edificioId);
    optionEspacios.each(function(index){
        $(this).removeAttr('hidden');
    });

    var selectEspacio = $('#espacio');
    $(selectEspacio).val('').trigger('change');
}