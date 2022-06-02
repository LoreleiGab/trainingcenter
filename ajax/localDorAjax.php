<?php

use TrainingCenter\Controllers\Administrativo\LocalDorController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $localDorObj = new LocalDorController();

    switch ($_POST['_method']){
        case "cadastraLocalDor":
            echo $localDorObj->cadastrarLocalDor($_POST);
            break;
        case "editaLocalDor":
            echo $localDorObj->editarLocalDor($_POST, $_POST['id']);
            break;
        case "apagaLocalDor":
            echo $localDorObj->apagarLocalDor($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}