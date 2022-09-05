<?php

use TrainingCenter\Controllers\Atleta\EsforcoController;
$esforcoObj = new EsforcoController();

$id = $_GET['id'] ?? null;
$athele_id = 1; //provisório

if ($id){
    $esforco = $esforcoObj->recuperarEsforco($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de percepção do esforço</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/esforcoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaEsforco" : "cadastraEsforco" ?>">
                        <input type="hidden" name="athlete_id" value="<?= $athele_id ?>">
                        <input type="hidden" name="data" value="<?= date('Y-m-d') ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="psr">PSR: *</label>
                                    <input type="number" class="form-control" id="psr" name="psr" min="0" max="99" value="<?= $esforco->psr ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="pse">PSE: *</label>
                                    <input type="number" class="form-control" id="pse" name="pse" min="0" max="99" value="<?= $esforco->pse ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="sleeping_hour_id">Horas dormidas: *</label>
                                    <select class="form-control select2bs4" id="sleeping_hour_id" name="sleeping_hour_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $esforcoObj->geraOpcao("sleeping_hours",$esforco->sleeping_hour_id ?? null); ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="stress">Estresse: *</label>
                                    <input type="number" class="form-control" id="stress" name="stress" min="0" max="99" value="<?= $esforco->stress ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>atleta/esforco_lista">
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