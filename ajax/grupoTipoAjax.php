<?php

use TrainingCenter\Controllers\Administrativo\GrupoTipoController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $grupoTipoObj = new GrupoTipoController();

    switch ($_POST['_method']){
        case "cadastraGrupoTipo":
            echo $grupoTipoObj->cadastrarGrupoTipo($_POST);
            break;
        case "editaGrupoTipo":
            echo $grupoTipoObj->editarGrupoTipo($_POST, $_POST['id']);
            break;
        case "apagaGrupoTipo":
            echo $grupoTipoObj->apagarGrupoTipo($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}