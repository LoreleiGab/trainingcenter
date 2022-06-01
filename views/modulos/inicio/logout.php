<?php

use TrainingCenter\Controllers\UsuarioController;

$usuarioObj = new UsuarioController();
$usuarioObj->gravarLog("Fez Logout");
$usuarioObj->forcarFimSessao();