<?php

use TrainingCenter\Controllers\Administrativo\HorasDormidasController;

require_once "../config/configGeral.php";
require_once "../config/autoload_ajax.php";

if (isset($_POST['_method'])) {
    $horasObj = new HorasDormidasController();

    switch ($_POST['_method']){
        case "cadastraHorasDormidas":
            echo $horasObj->cadastrarHorasDormidas($_POST);
            break;
        case "editaHorasDormidas":
            echo $horasObj->editarHorasDormidas($_POST, $_POST['id']);
            break;
        case "apagaHorasDormidas":
            echo $horasObj->apagarHorasDormidas($_POST['id']);
            break;
        default:
            include_once "../config/destroySession.php";
            break;
    }
} else{
    include_once "../config/destroySession.php";
}