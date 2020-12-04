$(document).ready(function() {
    $("#botonAddDepartamento").click(function(){
    $("#addDepartamentoForm").submit();
    return false;
});

    $("#botonAtrasAddDepartamento").click(function(){
        window.location.href = "../Controllers/Departamento_Controller.php?action=showall";
        return false;
    });
});