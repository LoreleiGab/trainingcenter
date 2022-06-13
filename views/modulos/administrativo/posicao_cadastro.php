<?php

use TrainingCenter\Controllers\Administrativo\PosicaoController;
$posicaoObj = new PosicaoController();

$id = $_GET['id'] ?? null;

if ($id){
    $posicao = $posicaoObj->recuperarPosicao($id);

}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de posição do atleta</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/posicaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaPosicao" : "cadastraPosicao" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="modality_id">Modalidade da posição: *</label>
                                    <select class="form-control select2bs4" id="modality_id" name="modality_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $posicaoObj->geraOpcao("modalities",$posicao->modality_id ?? null); ?>
                                    </select>
                                    <label for="posicao">Posição do Atleta: *</label>
                                    <input type="text" class="form-control" id="posicao" name="posicao" maxlength="20" value="<?= $posicao->posicao ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>administrativo/posicao_lista">
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