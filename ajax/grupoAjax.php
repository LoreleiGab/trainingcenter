<?php

use TrainingCenter\Controllers\Administrativo\GrupoController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $grupoObj = new GrupoController();

    switch ($_POST['_method']){
        case "cadastraGrupo":
            echo $grupoObj->cadastrarGrupo($_POST);
            break;
        case "editaGrupo":
            echo $grupoObj->editarGrupo($_POST, $_POST['id']);
            break;
        case "apagaGrupo":
            echo $grupoObj->apagarGrupo($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}