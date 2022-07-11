<?php

use TrainingCenter\Controllers\Preparador\AtletaController;
$atletaObj = new AtletaController();

$atletas = $atletaObj->listarAtleta();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-10">
                <h1 class="m-0 text-dark">Atletas</h1>
            </div><!-- /.col -->
            <div class="col-2">
                <a href="<?= SERVERURL ?>preparador/atleta_cadastro" class="btn btn-success btn-block"><i class="fas fa-plus"></i> Adicionar</a>
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
                                <th>Nome completo</th>
                                <th>Apelido</th>
                                <th>Data de nascimento</th>
                                <th>Equipe</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($atletas as $atleta): ?>
                            <tr>
                                <td><?= $atleta->nome_completo ?></td>
                                <td><?= $atleta->apelido ?></td>
                                <td><?= date('d/m/Y', strtotime($atleta->data_nascimento))  ?></td>
                                <td><?= $atleta->equipe  ?></td>
                                <td class="d-flex flex-row justify-content-around">
                                    <a href="<?= SERVERURL . "preparador/atleta_cadastro&id=" . $atletaObj->encryption($atleta->id) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/atletaAjax.php" role="form" data-form="delete">
                                        <input type="hidden" name="_method" value="apagaAtleta">
                                        <input type="hidden" name="id" value="<?= $atleta->id ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                        <div class="resposta-ajax"></div>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome completo</th>
                                <th>Apelido</th>
                                <th>Data de nascimento</th>
                                <th>Time</th>
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