<?php

use TrainingCenter\Controllers\UsuarioController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $usuarioObj = new UsuarioController();

    switch ($_POST['_method']){
        case "cadastraUsuario":
            echo $usuarioObj->cadastrarUsuario($_POST);
            break;
        case "editaUsuario":
            echo $usuarioObj->editarUsuario($_POST, $_POST['id']);
            break;
        case "trocaSenha":
            echo $usuarioObj->trocarSenha($_POST['id']);
            break;
        case "apagaUsuario":
            echo $usuarioObj->apagarUsuario($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}