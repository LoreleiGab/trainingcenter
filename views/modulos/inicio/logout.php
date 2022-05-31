<?php

use Gesp\Controllers\UsuarioController;

$usuarioObj = new UsuarioController();
$usuarioObj->gravarLog("Fez Logout");
$usuarioObj->forcarFimSessao();