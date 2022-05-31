<?php

use Gesp\Controllers\EstatisticaController;

$estatisticaObj = new EstatisticaController();
$ativos = $estatisticaObj->qtdeFuncionarioStatus(1);
$inativos = $estatisticaObj->qtdeFuncionarioStatus(2);
$cedidos = $estatisticaObj->qtdeFuncionarioStatus(3);
$supervisoes = $estatisticaObj->qtdeFuncionarioSupervisao();
$departamentos = $estatisticaObj->qtdeFuncionarioDepartamento();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Boas vindas ao GesP</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $ativos ?></h3>
                        <p>Funcionários Ativos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $inativos ?></h3>
                        <p>Funcionários Inativos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-minus"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $cedidos ?></h3>
                        <p>Funcionários Cedidos</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./row -->
        <div class="row">
            <div class="col-md">
                <div class="card card-info card-outline shadow">
                    <div class="card-header">
                        <h3 class="card-title">Quantidade de funcionários ativos por departamento e supervisão</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach ($departamentos as $departamento):  ?>
                            <div class="card collapsed-card">
                                <div class="card-header">
                                    <div class="progress-group">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                        </button>
                                        <span class="text-sm"><?= $departamento->departamento ?></span>
                                        <span class="float-right"><b><?= $departamento->quantidade ?></b></span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-primary" style="width: <?=$departamento->quantidade*100/$ativos ?>%"></div>
                                        </div>
                                    </div>

                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <?php
                                    $supervisoes = $estatisticaObj->qtdeFuncionarioSupervisao($departamento->id);
                                    foreach ($supervisoes as $supervisao){
                                        ?>
                                        <div class="progress-group">
                                            <?= $supervisao->supervisao ?>
                                            <span class="float-right"><b><?= $supervisao->quantidade ?></b></span>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar bg-teal" style="width: <?=$supervisao->quantidade*100/$departamento->quantidade ?>%"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- ./row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->