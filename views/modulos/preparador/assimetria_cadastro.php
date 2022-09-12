<?php

use TrainingCenter\Controllers\Preparador\AssimetriaController;
$assimetriaObj = new AssimetriaController();

$id = $_GET['id'] ?? null;

if ($id){
    $assimetria = $assimetriaObj->recuperarAssimetria($id);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de assimetria</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/assimetriaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                    <input type="hidden" name="_method" value="<?= ($id) ? "editaAssimetria" : "cadastraAssimetria" ?>">
                    <?php if ($id): ?>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="athlete">Atleta *</label>
                                    <select class="form-control select2bs4" name="athlete_id" id="athlete" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $assimetriaObj->geraOpcao("athletes", $assimetria->athlete_id ?? null);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="flex_joelho_direito">Flex. joelho direito: *</label>
                                    <input type="text" class="form-control decimal2-1" id="flex_joelho_direito" name="flex_joelho_direito" maxlength="5" value="<?= $assimetria->flex_joelho_direito ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="flex_joelho_esquerdo">Flex. joelho esquerdo: *</label>
                                    <input type="text" class="form-control decimal2-1" id="flex_joelho_esquerdo" name="flex_joelho_esquerdo" maxlength="5" value="<?= $assimetria->flex_joelho_esquerdo ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="exten_joelho_direito">Exten. joelho direito: *</label>
                                    <input type="text" class="form-control decimal2-1" id="exten_joelho_direito" name="exten_joelho_direito" maxlength="5" value="<?= $assimetria->exten_joelho_direito ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="exten_joelho_esquerdo">Exten. joelho esquerdo: *</label>
                                    <input type="text" class="form-control decimal2-1" id="exten_joelho_esquerdo" name="exten_joelho_esquerdo" maxlength="5" value="<?= $assimetria->exten_joelho_esquerdo ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="relacao_joelho_direito">Relação joelho direito: *</label>
                                    <input type="text" class="form-control decimal2-1" id="relacao_joelho_direito" name="relacao_joelho_direito" maxlength="5" value="<?= $assimetria->relacao_joelho_direito ?? null ?>" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="relacaoiq_joelho_esquerdo">Relação joelho direito: *</label>
                                    <input type="text" class="form-control decimal2-1" id="relacaoiq_joelho_esquerdo" name="relacaoiq_joelho_esquerdo" maxlength="5" value="<?= $assimetria->relacaoiq_joelho_esquerdo ?? null ?>" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>preparador/assimetria_lista">
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