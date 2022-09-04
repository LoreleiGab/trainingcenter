<?php

use TrainingCenter\Controllers\UsuarioController;
$usuarioObj = new UsuarioController();

$usuarios = $usuarioObj->listarUsuario();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-10">
                <h1 class="m-0 text-dark">Membros</h1>
            </div><!-- /.col -->
            <div class="col-2">
                <a href="<?= SERVERURL ?>administrativo/usuario_cadastro" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Adicionar</a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Listagem</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Apelido</th>
                                <th>Perfil</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?=$usuario->apelido ?></td>
                                <td><?=$usuario->perfil ?></td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a href="<?= SERVERURL . "administrativo/usuario_cadastro&id=" . $usuarioObj->encryption($usuario->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/usuarioAjax.php" role="form" data-form="delete">
                                        <input type="hidden" name="_method" value="apagaUsuario">
                                        <input type="hidden" name="id" value="<?= $usuario->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                        <div class="resposta-ajax"></div>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Apelido</th>
                                <th>Perfil</th>
                                <th>Ação</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>