<?php

use TrainingCenter\Controllers\Preparador\EquipeController;
$equipeObj = new EquipeController();

$id = $_GET['id'] ?? null;

if ($id){
    $equipe = $equipeObj->recuperarEquipe($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de equipe</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/equipeAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaEquipe" : "cadastraEquipe" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="modality">Modalidade *</label>
                                    <select class="form-control" name="modality_id" id="modality" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $equipeObj->geraOpcao("modalities", $equipe->modality_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="equipe">Equipe: *</label>
                                    <input type="text" class="form-control" id="equipe" name="equipe" maxlength="120" value="<?= $equipe->equipe ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>preparador/equipe_lista">
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