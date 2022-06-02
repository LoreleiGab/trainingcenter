<?php

use TrainingCenter\Controllers\Administrativo\MembroController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $membroObj = new MembroController();

    switch ($_POST['_method']){
        case "cadastraMembro":
            echo $membroObj->cadastrarMembro($_POST);
            break;
        case "editaMembro":
            echo $membroObj->editarMembro($_POST, $_POST['id']);
            break;
        case "apagaMembro":
            echo $membroObj->apagarMembro($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}