<?php

use TrainingCenter\Controllers\Administrativo\PosicaoController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $posicaoObj = new PosicaoController();

    switch ($_POST['_method']){
        case "cadastraPosicao":
            echo $posicaoObj->cadastrarPosicao($_POST);
            break;
        case "editaPosicao":
            echo $posicaoObj->editarPosicao($_POST, $_POST['id']);
            break;
        case "apagaPosicao":
            echo $posicaoObj->apagarPosicao($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}