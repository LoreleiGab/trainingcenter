<?php

use TrainingCenter\Controllers\Preparador\AtletaController;
$atletaObj = new AtletaController();

$id = $_GET['id'] ?? null;

if ($id){
    $atleta = $atletaObj->recuperarAtleta($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de atleta</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/atletaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaAtleta" : "cadastraAtleta" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <?php if (!$id): ?>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="user">Usuários disponíveis *</label>
                                        <select class="form-control select2bs4" name="user_id" id="user" required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php
                                            $atletaObj->geraOpcaoNovoAtleta($atleta->user_id ?? null);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nome_completo">Nome completo: *</label>
                                    <input type="text" class="form-control" id="nome_completo" name="nome_completo" maxlength="120" value="<?= $atleta->nome_completo ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="apelido">Apelido: *</label>
                                    <input type="text" class="form-control" id="apelido" name="apelido" maxlength="20" value="<?= $atleta->apelido ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_nascimento">Data de nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= $atleta->data_nascimento ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="altura">Altura: *</label>
                                    <input type="text" class="form-control altura" id="altura" name="altura" maxlength="4" value="<?= $atleta->altura ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="peso">Peso: *</label>
                                    <input type="text" class="form-control peso" id="peso" name="peso" maxlength="5" value="<?= $atleta->peso ?? null ?>" required>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="percentual_gordura">% Gordura: *</label>
                                    <input type="number" class="form-control" id="percentual_gordura" name="percentual_gordura" min="0" max="99" maxlength="2" value="<?= $atleta->percentual_gordura ?? null ?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="team">Equipe *</label>
                                    <select class="form-control" name="team_id" id="team" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $atletaObj->geraOpcao("teams", $atleta->team_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="modality">Modalidade *</label>
                                    <select class="form-control" name="modality_id" id="modality" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $atletaObj->geraOpcao("modalities", $atleta->modality_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="position">Posição *</label>
                                    <select class="form-control" name="position_id" id="position" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $atletaObj->geraOpcao("positions", $atleta->position_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="member">Membro *</label>
                                    <select class="form-control" name="member_id" id="member" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $atletaObj->geraOpcao("members", $atleta->member_id ?? null);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>preparador/atleta_lista">
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