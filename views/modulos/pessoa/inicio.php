<?php

use TrainingCenter\Controllers\Pessoa\FeriasController;

$url = SERVERURL.'api/departamento_supervisao.php';
$urlPdfs = SERVERURL.'api/gerar_pdfs_ferias.php';

$feriasObj = new FeriasController();
$busca = false;

if (isset($_POST['_method'])) {
    unset($_POST['_method']);
    $departamento_id = $_POST['departamento_id'];
    $resultados = $feriasObj->listar($_POST);
    foreach ($_POST as $key => $pesquisa) {
        if ($pesquisa !== "") {
            $dado = str_replace('.', 'p', str_replace('/', 'b', str_replace('-', 't', $pesquisa)));
        }
    }
    $busca = true;
}
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
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pesquisa para emissão de aviso de férias</h3>
                    </div>
                    <!-- /.card-header -->
                    <form id="pesquisar" method="post" class="has-validation">
                        <input type="hidden" name="_method" value="pesquisar">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <label for="departamento">Departamento</label>
                                    <select class="form-control" id="departamento" name="departamento_id">
                                        <option value="">Selecione...</option>
                                        <?php $feriasObj->geraOpcaoDepartamentos('departamentos', $departamento_id ?? "") ?>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="supervisao">Supervisão:</label>
                                    <select class="form-control" id="supervisao" name="supervisao_id">
                                        <option value="">Selecione uma supervisão...</option>
                                        <!-- Alimentado via JS -->
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="card-footer border border-primary">
                                        <div class="row">
                                            <div class="col">
                                                Insira o período de pesquisa das férias
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="periodo_inicio">Inicia-se em:</label>
                                                <input type="date" class="form-control validaDatas" id="periodo_inicio" name="periodo_inicio">
                                            </div>
                                            <div class="col">
                                                <label for="periodo_fim">Até:</label>
                                                <input type="date" class="form-control validaDatas" id="periodo_fim" name="periodo_fim">
                                                <span id="periodo_fim-error" class="error invalid-feedback">A <u><strong>data final</strong></u> deve ser maior que a <u><strong>data inicial</strong></u></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button id="pesquisa" class="btn btn-info float-right">Pesquisar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <?php
        if ($busca) {
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Resultados</h3>
                            <?php if (!empty($resultados)): ?>
                                <div class="card-tools">
                                    <form target="_blank" action="<?= SERVERURL ?>api/gerar_pdfs_ferias.php" method="post">
                                        <?php foreach ($resultados as $resultado): ?>
                                            <input type="hidden" name="ferias_id[]" value="<?= (new MainModel)->encryption($resultado->id) ?>">
                                        <?php endforeach ?>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Gerar PDFs com os resultados
                                        </button>
                                    </form>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="card-body overflow-auto">
                            <table id="tabela1" class="table table-bordered table-striped tabela-completa">
                                <thead>
                                    <tr>
                                        <th>Departamento</th>
                                        <th>Supervisão</th>
                                        <th>Nome Completo</th>
                                        <th style="width: 6%">RF</th>
                                        <th>Data de Início</th>
                                        <th>Data de Fim</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($resultados)): ?>
                                    <?php foreach ($resultados as $resultado): ?>
                                        <tr>
                                            <td><?= $resultado->sigla ?></td>
                                            <td><?= $resultado->supervisao ?></td>
                                            <td><?= $resultado->nome_completo ?></td>
                                            <td><?= $resultado->rf ?></td>
                                            <td><?= $resultado->data_inicio ?></td>
                                            <td><?= $resultado->data_fim ?></td>
                                            <td class="d-flex justify-content-between">
                                                <a href="<?= SERVERURL ?>pdf/aviso_ferias.php?id=<?= (new MainModel)->encryption($resultado->id) ?>"
                                                   target="_blank" class="btn btn-sm bg-gradient-purple mr-2"> <i
                                                            class="fas fa-print"></i> Gerar Aviso de Férias </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Departamento</th>
                                        <th>Supervisão</th>
                                        <th>Nome Completo</th>
                                        <th>RF</th>
                                        <th>Data de Início</th>
                                        <th>Data de Fim</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
const urlAPI = '<?=$url?>';

let departamento = document.querySelector('#departamento');
let supervisao_id = '<?=$_POST['supervisao_id'] ?? ""?>';

if (departamento.value != '') {
    getLocais(departamento.value, supervisao_id)
}

        departamento.addEventListener('change', async e => {
            let departamento_id = $('#departamento option:checked').val();
            let campoSupervisao = $('#supervisao');

            fetch(`${urlAPI}?departamento_id=${departamento_id}`)
                .then((response) => response.json())
                .then(supervisoes => {
                    $('#supervisao option').remove();

                    if (supervisoes.length) {
                        campoSupervisao.append('<option value="">Selecione uma opção...</option>');
                        for (const supervisao of supervisoes) {
                            campoSupervisao.append(`<option value='${supervisao.id}'>${supervisao.supervisao}</option>`).focus();
                        }
                    } else {
                        campoSupervisao.append('<option value="">Nenhuma supervisão cadastrada</option>');
                    }
                })
        })

function getLocais(departamento_id, selectedId) {
    fetch(`${urlAPI}?departamento_id=${departamento_id}`)
        .then(response => response.json())
        .then(supervisoes => {
            $('#supervisao option').remove();
            $('#supervisao').append('<option value="">Selecione uma opção...</option>');

            for (const supervisao of supervisoes) {
                if (selectedId == supervisao.id) {
                    $('#supervisao').append(`<option value='${supervisao.id}' selected>${supervisao.supervisao}</option>`).focus();
                    ;
                } else {
                    $('#supervisao').append(`<option value='${supervisao.id}'>${supervisao.supervisao}</option>`).focus();
                    ;
                }

            }
        })
}
</script>

<script>
    // Valida datas de fim, pagamento e data de inicio da segunda parcela
    // para que cada uma delas não seja menor que a anterior
    $('.validaDatas').change(function () {
        let periodo_inicio = new Date($('#periodo_inicio').val());
        let periodo_fim = new Date($('#periodo_fim').val());

        if (periodo_fim.getTime() <= periodo_inicio.getTime()) {
            $('#periodo_fim').addClass('is-invalid');
        } else {
            $('#periodo_fim').removeClass('is-invalid');
        }

        if ($('.is-invalid').length) {
            $('#pesquisa').attr('disabled', true)
        } else {
            $('#pesquisa').attr('disabled', false)
        }
    });
    // Fim das validações das datas
</script>
