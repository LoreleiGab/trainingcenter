<?php

use TrainingCenter\Controllers\Administrativo\CargoController;
$cargoObj = new CargoController();

$cargos = $cargoObj->listarCargo();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-10">
                <h1 class="m-0 text-dark">Cargos</h1>
            </div><!-- /.col -->
            <div class="col-2">
                <a href="<?= SERVERURL ?>administrativo/cargo_cadastro" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Adicionar</a>
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
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Padrão</th>
                                <th>Nível</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cargos as $cargo): ?>
                            <tr>
                                <td><?=$cargo->codigo ?></td>
                                <td><?=$cargo->cargo ?></td>
                                <td><?=$cargo->padrao_id ?? null ?></td>
                                <td><?=$cargo->nivel ?? null ?></td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a href="<?= SERVERURL . "administrativo/cargo_cadastro&id=" . $cargoObj->encryption($cargo->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/cargoAjax.php" role="form" data-form="delete">
                                        <input type="hidden" name="_method" value="apagaCargo">
                                        <input type="hidden" name="idCargo" value="<?= $cargo->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                        <div class="resposta-ajax"></div>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Código</th>
                                <th>Descrição</th>
                                <th>Padrão</th>
                                <th>Nível</th>
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