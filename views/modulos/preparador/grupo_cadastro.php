<?php

use TrainingCenter\Controllers\Preparador\GrupoController;
$grupoObj = new GrupoController();

$id = $_GET['id'] ?? null;

if ($id){
    $grupo = $grupoObj->recuperarGrupo($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de grupo</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/grupoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaGrupo" : "cadastraGrupo" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="team">Modalidade *</label>
                                    <select class="form-control" name="team_id" id="team" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $grupoObj->geraOpcao("teams", $grupo->team_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="group_type">Tipo do grupo *</label>
                                    <select class="form-control" name="group_type_id" id="group_type" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $grupoObj->geraOpcao("group_types", $grupo->group_type_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="data">Data: *</label>
                                    <input type="date" class="form-control" id="data" name="data" value="<?= $grupo->data ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="minutagem">Minutagem: *</label>
                                    <input type="number" class="form-control" id="minutagem" name="minutagem" min="0" max="999" maxlength="3" value="<?= $grupo->minutagem ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="percepcao_planejada">Percepção planejada: *</label>
                                    <input type="number" class="form-control" id="percepcao_planejada" name="percepcao_planejada" min="0" max="99" maxlength="2" value="<?= $grupo->percepcao_planejada ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>preparador/grupo_lista">
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