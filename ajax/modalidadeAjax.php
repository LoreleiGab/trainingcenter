<?php

use TrainingCenter\Controllers\Administrativo\ModalidadeController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $membroObj = new ModalidadeController();

    switch ($_POST['_method']){
        case "cadastraModalidade":
            echo $membroObj->cadastrarModalidade($_POST);
            break;
        case "editaModalidade":
            echo $membroObj->editarModalidade($_POST, $_POST['id']);
            break;
        case "apagaModalidade":
            echo $membroObj->apagarModalidade($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}