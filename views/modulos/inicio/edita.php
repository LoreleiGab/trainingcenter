<?php

use TrainingCenter\Controllers\UsuarioController;

$id = $_SESSION['usuario_id_tc'];

$objUsuario = new UsuarioController();
$usuario = $objUsuario->recuperaUsuario($id)->fetchObject();

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Minha conta</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados pessoais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body register-card-body">
                        <label>Nome:</label> <?=$usuario->apelido?>
                        <hr>
                        <label>Telefone:</label> <?=$usuario->telefone?>
                        <hr>
                        <label>E-mail:</label> <?=$usuario->email?>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Trocar senha</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body register-card-body">
                        <form class="needs-validation formulario-ajax" data-form="update" action="<?=SERVERURL?>ajax/usuarioAjax.php" method="post">
                            <input type="hidden" name="_method" value="trocaSenhaUsuario">
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="senha">Senha: *</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="senha">Confirme sua senha: *</label>
                                    <input type="password" class="form-control" id="senha2" name="senha2" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-info btn-block btn-flat">Trocar</button>
                            </div>
                            <div class="resposta-ajax">

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->