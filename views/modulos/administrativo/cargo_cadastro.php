<?php

use TrainingCenter\Controllers\Administrativo\CargoController;
$cargoObj = new CargoController();

$id = $_GET['id'] ?? null;

if ($id){
    $cargo = $cargoObj->recuperarCargo($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de cargo</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/cargoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaCargo" : "cadastraCargo" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="codigo">Código: *</label>
                                    <input type="number" class="form-control" id="codigo" name="codigo" min= 0 maxlength="7" value="<?= $cargo->codigo ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="descricao">Descrição: *</label>
                                    <input type="text" class="form-control" id="descricao" name="cargo" maxlength="50" value="<?= $cargo->cargo ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="padrao">Padrão:</label>
                                    <select class="form-control select2bs4" id="padrao" name="padrao_id">
                                        <option value="">Selecione...</option>
                                        <?php $cargoObj->geraOpcao("padroes", $cargo->padrao_id ?? null) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="nivel">Nível:</label>
                                    <input type="text" class="form-control" id="nivel" name="nivel" maxlength="3" value="<?= $cargo->nivel ?? null ?>">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>administrativo/cargo_lista">
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