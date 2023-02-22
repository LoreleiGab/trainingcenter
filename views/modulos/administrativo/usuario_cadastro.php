<?php

use TrainingCenter\Controllers\UsuarioController;
$usuarioObj = new UsuarioController();

$id = $_GET['id'] ?? null;

if ($id){
    $usuario = $usuarioObj->recuperarUsuario($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de usuário</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/usuarioAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaUsuario" : "cadastraUsuario" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="modified" value="<?= date('Y-m-d H:i:s') ?>">
                    <?php else: ?>
                        <input type="hidden" name="password" value="trainingcenter123">
                        <input type="hidden" name="created" value="<?= date('Y-m-d H:i:s') ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <?php if ($id): ?>
                                    <div class="form-group col-md-1">
                                        <div class="widget-user widget-user-image">
                                            <img class="img-circle elevation-1" src="<?= SERVERURL ?>views/dist/img/user.png" height="60px" alt="User Image">
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group col-md">
                                    <label for="apelido">Apelido: *</label>
                                    <input type="text" class="form-control" id="apelido" name="apelido" maxlength="20" value="<?= $usuario->apelido ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">E-mail *</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" required id="email" value="<?= $usuario->email ?? null ?>">
                                    <div class="invalid-feedback">
                                        <strong>Email já cadastrado</strong>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tel_usuario">Telefone* </label>
                                    <input type="text" id="tel_usuario" name="telefone" class="form-control" onkeyup="mascara( this, mtel );" required maxlength="15" value="<?= $usuario->telefone ?? null ?>">
                                </div>

                                <div class="form-group col-md">
                                    <label for="profile_id">Perfil: *</label>
                                    <select class="form-control select2bs4" id="profile_id" name="profile_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $usuarioObj->geraOpcao("profiles",$usuario->profile_id ?? null); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>administrativo/usuario_lista">
                                <button type="button" class="btn btn-default pull-left">Voltar</button>
                            </a>
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>