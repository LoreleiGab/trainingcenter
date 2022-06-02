<?php

use TrainingCenter\Controllers\Administrativo\LocalDorController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $membroObj = new LocalDorController();

    switch ($_POST['_method']){
        case "cadastraLocalDor":
            echo $membroObj->cadastrarLocalDor($_POST);
            break;
        case "editaLocalDor":
            echo $membroObj->editarLocalDor($_POST, $_POST['id']);
            break;
        case "apagaLocalDor":
            echo $membroObj->apagarLocalDor($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}