<?php

use Gesp\Controllers\UsuarioController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $usuarioObj = new UsuarioController();

    switch ($_POST['_method']){
        case "cadastraUsuario":
            echo $usuarioObj->cadastrar($_POST);
            break;
        case "editaUsuario":
            echo $usuarioObj->editar($_POST, $_POST['pessoa_id']);
            break;
        case "trocaSenha":
            echo $usuarioObj->trocarSenha($_POST['id']);
            break;
        case "removerUsuario":
            echo $usuarioObj->remover($_POST['pessoa_id']);
            break;
        case "reativarUsuario":
            echo $usuarioObj->reativarUsuario($_POST['pessoa_id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}