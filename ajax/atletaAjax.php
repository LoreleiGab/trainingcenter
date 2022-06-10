<?php

use TrainingCenter\Controllers\Preparador\AtletaController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $atletaObj = new AtletaController();

    switch ($_POST['_method']){
        case "cadastraAtleta":
            echo $atletaObj->cadastrarAtleta($_POST);
            break;
        case "editaAtleta":
            echo $atletaObj->editarAtleta($_POST, $_POST['id']);
            break;
        case "apagaAtleta":
            echo $atletaObj->apagarAtleta($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}