<?php
//include '../Models/Access_DB.php';
if(!@include_once('../Models/USUARIO_Model.php')) {
    include '../Models/USUARIO_Model.php';
}


function esAdministrador(){
    if (!isset($_SESSION['login'])){
        return false;
    }
    else{
        if($_SESSION['rol'] == "ADMIN"){
            return true;
        }
        else{
            return false;
        }
    }
}
?>

