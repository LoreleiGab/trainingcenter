<?php
$pedidoAjax = false;

require_once "config/configGeral.php";
require_once "config/autoload.php";
require_once "Controllers/Administrativo/CargoController.php";

use TrainingCenter\Controllers\ViewsController;

$template = new ViewsController();

$template->exibirTemplate();