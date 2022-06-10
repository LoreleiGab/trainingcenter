<?php

use TrainingCenter\Controllers\Preparador\EquipeController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $equipeObj = new EquipeController();

    switch ($_POST['_method']){
        case "cadastraEquipe":
            echo $equipeObj->cadastrarEquipe($_POST);
            break;
        case "editaEquipe":
            echo $equipeObj->editarEquipe($_POST, $_POST['id']);
            break;
        case "apagaEquipe":
            echo $equipeObj->apagarEquipe($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}