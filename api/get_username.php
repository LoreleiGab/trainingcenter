<?php

use Gesp\Models\MainModel;

require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
require_once "../config/autoload_ajax.php";

$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

if(isset($_GET['pessoa_id']) || isset($_POST['pessoa_id'])){
    $id = $_GET['pessoa_id'] ?? $_POST['pessoa_id'];

    $cst = $db->consultaSimples("SELECT rf FROM pessoas WHERE id = '$id'")->fetchColumn();
    $usuario['usuario'] = "d" . substr($cst, 0, 6);
    $userName = json_encode($usuario);
    print_r($userName);
}