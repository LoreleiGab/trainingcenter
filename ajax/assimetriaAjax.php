<?php

use TrainingCenter\Controllers\Preparador\AssimetriaController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $grupoObj = new AssimetriaController();

    switch ($_POST['_method']){
        case "cadastraAssimetria":
            echo $grupoObj->cadastrarAssimetria($_POST);
            break;
        case "editaAssimetria":
            echo $grupoObj->editarAssimetria($_POST, $_POST['id']);
            break;
        case "apagaAssimetria":
            echo $grupoObj->apagarAssimetria($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}