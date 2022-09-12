<?php

use TrainingCenter\Controllers\Preparador\AssimetriaController;
$assimetriaObj = new AssimetriaController();

$assimetrias = $assimetriaObj->listarAssimetria();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-10">
                <h1 class="m-0 text-dark">Assimetrias</h1>
            </div><!-- /.col -->
            <div class="col-2">
                <a href="<?= SERVERURL ?>preparador/assimetria_cadastro" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Adicionar</a>
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
                                <th>Atleta</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($assimetrias as $assimetria): ?>
                            <tr>
                                <td><?= $assimetria->nome_completo ?></td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a href="<?= SERVERURL . "preparador/assimetria_cadastro&id=" . $assimetriaObj->encryption($assimetria->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/assimetriaAjax.php" role="form" data-form="delete">
                                        <input type="hidden" name="_method" value="apagaAssimetria">
                                        <input type="hidden" name="id" value="<?= $assimetria->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                        <div class="resposta-ajax"></div>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Atleta</th>
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