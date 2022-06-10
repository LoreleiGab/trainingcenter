<?php

use TrainingCenter\Controllers\Atleta\EsforcoController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $esforcoObj = new EsforcoController();

    switch ($_POST['_method']){
        case "cadastraEsforco":
            echo $esforcoObj->cadastrarEsforco($_POST);
            break;
        case "editaEsforco":
            echo $esforcoObj->editarEsforco($_POST, $_POST['id']);
            break;
        case "apagaEsforco":
            echo $esforcoObj->apagarEsforco($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}