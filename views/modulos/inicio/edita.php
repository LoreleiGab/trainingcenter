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
            <div class="col-md-2">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="https://letrasjuridicas.com.br/product_images/AuthorDefaultImage.png" alt="User profile picture">
                        </div>
                        <br>
                        <h3 class="profile-username text-center"><?=$usuario->apelido?></h3>
                        <p class="text-muted text-center"><?=$usuario->perfil?></p>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <!-- Horizontal Form -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Nome</b> <a class="float-right"><?=$usuario->apelido?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Telefone:</b> <a class="float-right"><?=$usuario->telefone?></a>
                            </li>
                            <li class="list-group-item">
                                <b>E-mail:</b> <a class="float-right"><?=$usuario->email?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Primeiro acesso:</b> <a class="float-right"><?=$usuario->created?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-primary card-outline">
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
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Trocar</button>
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