<?php

use TrainingCenter\Controllers\Pessoa\PessoaController;
use TrainingCenter\Models\MainModel;

$id = $_GET['id'] ?? null;

$pessoaObj = new PessoaController();

if (isset($_POST['rf'])){
    $rf = $_POST['rf'];
    $pessoa = $pessoaObj->getRf($rf);
    if ($pessoa){
        $id = (new MainModel)->encryption($pessoa->id);
    }
}

if ($id){
    $pessoa = $pessoaObj->recuperar($id);
    $rf = $pessoa->rf;

    if ($pessoa) {
        switch ($pessoa->status) {
            case 1:
                $link = "funcionario_ativo_lista";
                break;

            case 2:
                $link = "funcionario_inativo_lista";
                break;

            case 3:
                $link = "funcionario_cedido_lista";
                break;
        }
    }
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Funcionário</h1>
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
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <?php if ($id){ ?>
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Resumo</a>
                                </li>
                            <?php } ?>
                            <?php if ($_SESSION['profile_tc'] != 3): // 3-leitor ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= (!$id) ? "active" : "" ?>" id="custom-tabs-one-pessoal-tab" data-toggle="pill" href="#custom-tabs-one-pessoal" role="tab" aria-controls="custom-tabs-one-pessoal" aria-selected="false">Principal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-banco-tab" data-toggle="pill" href="#custom-tabs-one-banco" role="tab" aria-controls="custom-tabs-one-banco" aria-selected="false">Banco</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-documento-tab" data-toggle="pill" href="#custom-tabs-one-documento" role="tab" aria-controls="custom-tabs-one-documento" aria-selected="false">Documentos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-endereco-tab" data-toggle="pill" href="#custom-tabs-one-endereco" role="tab" aria-controls="custom-tabs-one-endereco" aria-selected="false">Endereço</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-parentesco-tab" data-toggle="pill" href="#custom-tabs-one-parentesco" role="tab" aria-controls="custom-tabs-one-parentesco" aria-selected="false">Parentesco</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= SERVERURL ?>pessoa/vinculo_lista&pessoa=<?=$id?>" class="btn btn-primary">Vínculo</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/pessoaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H:i:s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <?php if ($id){ ?>
                                    <!--<editor-fold desc="Resumo">-->
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <p>
                                        <b>Nome:</b> <?= $pessoa->nome_completo ?? null ?> | <b>RF:</b> <?= $pessoa->rf ?? null ?> | <b>Status:</b> <?= $pessoa->status ?? null ?><br>
                                        <b>E-mail:</b> <?= $pessoa->email ?? "" ?> | <b>Telefones:</b> <?= isset($pessoa->telefones) ? implode(' - ', $pessoa->telefones) : ''  ?><br>
                                        <b>Gênero:</b> <?= $pessoa->genero ?? null ?><br>
                                        <b>Estado civil:</b> <?= $pessoa->estado_civil ?? null ?><br>
                                        <b>Grau de instrução:</b>  <?= $pessoa->grau_instrucao ?? null ?> | <b>Curso:</b> <?= $pessoa->curso ?? null ?><br>
                                        <b>Data de nascimento:</b> <?= date('d/m/Y', strtotime($pessoa->data_nascimento ?? null)) ?> | <b>Nacionalidade:</b> <?= $pessoa->nacionalidade ?? null ?> | <b>Natural estado:</b> <?= $pessoa->natural_estado ?? null ?> | <b>Natural cidade:</b> <?= $pessoa->natural_cidade ?? null ?>
                                    </p>
                                    <p>
                                        <b>Banco:</b> <?= $pessoa->banco ?? null ?> | <b>Agência:</b> <?= $pessoa->agencia ?? null ?> | <b>Conta:</b> <?= $pessoa->conta ?? null ?>
                                    </p>
                                    <p>
                                        <b>CPF:</b> <?= $pessoa->cpf ?? null ?> |  <b>RG:</b> <?= $pessoa->rg ?? null . " - " . $pessoa->rg_uf ?? null ?> <br>
                                        <b>Pis/Pasep:</b> <?= $pessoa->pis_pasep ?? null ?><br>
                                        <b>CNH número:</b> <?= $pessoa->cnh_numero ?? null ?> | <b>Categoria:</b> <?= $pessoa->categoria ?? null ?> | <b>Validade:</b> <?= date('d/m/Y', strtotime($pessoa->validade ?? "")) ?><br>
                                        <b>Título eleitoral:</b> <?= $pessoa->titulo_numero ?? null ?> | <b>Seção:</b> <?= $pessoa->secao ?? null ?> | <b>Zona:</b> <?= $pessoa->zona ?? null ?>
                                    </p>
                                    <p>
                                        <b>Endereço:</b> <?= isset($pessoa->logradouro) ?  $pessoa->logradouro . ", " . $pessoa->numero . " " . $pessoa->complemento . " - " . $pessoa->bairro . ", " . $pessoa->cidade . " - " . $pessoa->uf . " CEP: " . $pessoa->cep : null ?>
                                    </p>
                                    <p>
                                        <b>Quantidade de dependentes:</b> <?= $pessoa->quantidade_dependente ?? "" ?><br>
                                        <b>Nome do cônjuge:</b> <?= $pessoa->conjuge_nome ?? null ?><br>
                                        <b>Nome da mãe:</b> <?= $pessoa->nome_mae ?? null ?><br>
                                        <b>Nome do pai:</b> <?= $pessoa->nome_pai ?? null ?><br>
                                    </p>
                                    <p>
                                        <b>Data da última atualização do cadastro:</b> <?= $pessoa->ultima_atualizacao ? date('d/m/Y H:i:s', strtotime($pessoa->ultima_atualizacao)) : "não registrado" ?>
                                    </p>
                                </div>
                                <!--</editor-fold>-->
                                <?php } ?>
                                <!--<editor-fold desc="Pessoal">-->
                                <div class="tab-pane fade <?= (!$id) ? "show active" : "" ?>" id="custom-tabs-one-pessoal" role="tabpanel" aria-labelledby="custom-tabs-one-pessoal-tab">
                                    <div class="row">
                                        <div class="form-group col-md-8">
                                            <label for="nome">Nome: *</label>
                                            <input type="text" class="form-control" id="nome" name="pf_nome_completo" placeholder="Digite o nome" maxlength="70" value="<?= $pessoa->nome_completo ?? null ?>" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pf_rf">RF *</label>
                                            <input type="text" class="form-control" id="pf_rf" name="pf_rf"  maxlength="7" value="<?= $rf ?? null ?>" readonly required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pf_status_id">Status *</label>
                                            <select class="form-control select2bs4" id="pf_status_id" name="pf_status_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php $pessoaObj->geraOpcao("status",$pessoa->status_id ?? null, true);  ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="email">E-mail:</label>
                                            <input type="email" id="email" name="pf_email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pessoa->email ?? "" ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="telefone">Telefone #1: *</label>
                                            <input type="text" id="telefone" name="te_telefones_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pessoa->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="telefone1">Telefone #2:</label>
                                            <input type="text" id="telefone1" name="te_telefones_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pessoa->telefones['tel_1'] ?? "" ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="telefone2">Telefone #3:</label>
                                            <input type="text" id="telefone2" name="te_telefones_3" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pessoa->telefones['tel_2'] ?? "" ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-2">
                                            <label for="genero">Gênero: *</label>
                                            <select class="form-control select2bs4" id="genero" name="pf_genero_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php $pessoaObj->geraOpcao("generos",$pessoa->genero_id ?? null, true);  ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="estado_civil_id">Estado civil: *</label>
                                            <select class="form-control select2bs4" id="estado_civil_id" name="pf_estado_civil_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php $pessoaObj->geraOpcao("estado_civis",$pessoa->estado_civil_id ?? null, true); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="grau_instrucao_id">Grau Instrução: *</label>
                                            <select class="form-control select2bs4" id="grau_instrucao_id" name="pf_grau_instrucao_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php
                                                $pessoaObj->geraOpcao("grau_instrucoes",$pessoa->grau_instrucao_id ?? null);
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col">
                                            <label for="curso">Curso:</label>
                                            <select class="form-control select2bs4" id="curso" name="cr_curso_id">
                                                <option value="">Selecione uma opção...</option>
                                                <?php $pessoaObj->geraOpcao("cursos",$pessoa->curso_id ?? null, true) ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="data_nascimento">Data de Nascimento: *</label>
                                            <input type="date" class="form-control" id="data_nascimento" name="pf_data_nascimento" onkeyup="barraData(this);" value="<?= $pessoa->data_nascimento ?? "" ?>" required >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="nacionalidade">Nacionalidade: *</label>
                                            <select class="form-control select2bs4" id="nacionalidade" name="pf_nacionalidade_id" required>
                                                <option value="">Selecione uma opção...</option>
                                                <?php $pessoaObj->geraOpcao("nacionalidades",$pessoa->nacionalidade_id ?? ''); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pf_natural_estado">Natural estado:</label>
                                            <input type="text" id="pf_natural_estado" name="pf_natural_estado" class="form-control"  maxlength="2" value="<?= $pessoa->natural_estado ?? null ?>">
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="pf_natural_cidade">Natural cidade:</label>
                                            <input type="text" id="pf_natural_cidade" name="pf_natural_cidade" class="form-control"  maxlength="25" value="<?= $pessoa->natural_cidade ?? null ?>">
                                        </div>
                                    </div>

                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Banco">-->
                                <div class="tab-pane fade" id="custom-tabs-one-banco" role="tabpanel" aria-labelledby="custom-tabs-one-banco-tab">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="banco">Banco:</label>
                                            <select id="banco" name="bc_banco_codigo" class="form-control select2bs4">
                                                <option value="">Selecione um banco...</option>
                                                <?php $pessoaObj->geraOpcao("bancos", $pessoa->banco_codigo) ?? null ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="agencia">Agência:</label>
                                            <input type="text" id="agencia" name="bc_agencia" class="form-control" placeholder="Digite a Agência" maxlength="12" value="<?= $pessoa->agencia ?? "" ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="conta">Conta:</label>
                                            <input type="text" id="conta" name="bc_conta" class="form-control" placeholder="Digite a Conta" maxlength="12" value="<?= $pessoa->conta ?? "" ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Documentos">-->
                                <div class="tab-pane fade" id="custom-tabs-one-documento" role="tabpanel" aria-labelledby="custom-tabs-one-documento-tab">
                                    <div class="row">
                                        <div class="form-group col-md-2">
                                            <label for="cpf">CPF: *</label>
                                            <input type="text" name="pf_cpf" class="form-control" id="cpf" maxlength="14" value="<?= $pessoa->cpf ?? null ?>" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pf_rg">RG: *</label>
                                            <input type="text" class="form-control" id="pf_rg" name="pf_rg" maxlength="20" value="<?= $pessoa->rg ?? ""?>" required>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label for="pf_rg_uf">RG UF:</label>
                                            <input type="text" id="pf_rg_uf" name="pf_rg_uf" class="form-control"  maxlength="2" value="<?= $pessoa->rg_uf ?? null ?>" required>
                                        </div>
                                        <div class="form-group col">
                                            <label for="pf_pis_pasep">Pis/Pasep:</label>
                                            <input type="text" class="form-control" name="pf_pis_pasep" id="pf_pis_pasep" maxlength="11" value="<?= $pessoa->pis_pasep ?? "" ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md">
                                            <label for="cn_numero">CNH número:</label>
                                            <input type="text" id="cn_numero" name="cn_numero" class="form-control"  maxlength="10" value="<?= $pessoa->cnh_numero ?? null ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="cn_categoria">CNH categoria.:</label>
                                            <input type="text" id="cn_categoria" name="cn_categoria" class="form-control"  maxlength="6" value="<?= $pessoa->categoria ?? null ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="cn_validade">CNH validade:</label>
                                            <input type="date" class="form-control" id="cn_validade" name="cn_validade"  value="<?= $pessoa->validade ?? null ?>">
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="ti_numero">Título número:</label>
                                            <input type="text" id="ti_numero" name="ti_numero" class="form-control"  maxlength="14" value="<?= $pessoa->titulo_numero ?? null ?>">
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="ti_secao">Título seção:</label>
                                            <input type="text" id="ti_secao" name="ti_secao" class="form-control"  maxlength="4" value="<?= $pessoa->secao ?? null ?>">
                                        </div>
                                        <div class="form-group col-md">
                                            <label for="ti_zona">Título zona:</label>
                                            <input type="text" id="ti_zona" name="ti_zona" class="form-control"  maxlength="5" value="<?= $pessoa->zona ?? null ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Endereço">-->
                                <div class="tab-pane fade" id="custom-tabs-one-endereco" role="tabpanel" aria-labelledby="custom-tabs-one-endereco-tab">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label for="cep">CEP: *</label>
                                            <input type="text" class="form-control" name="en_cep" id="cep" onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pessoa->cep ?? "" ?>" >
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>&nbsp;</label><br>
                                            <input type="button" class="btn btn-primary" value="Carregar">
                                        </div>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="form-group col-3">
                                            <label for="rua">Rua: *</label>
                                            <input type="text" class="form-control" name="en_logradouro" id="rua" placeholder="Digite a rua" maxlength="200" value="<?= $pessoa->logradouro ?? "" ?>" readonly>
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="numero">
                                                Número: *
                                                <button type="button" class="btn btn-sm btn-default rounded-circle"  data-toggle="popover" data-content="Caso não houver colocar 0" data-placement="top">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </label>
                                            <input type="number" min="0" maxlength="5" id="numero" name="en_numero" class="form-control" placeholder="Ex.: 10" value="<?= $pessoa->numero ?? "" ?>" required>
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="complemento">Complemento:</label>
                                            <input type="text" id="complemento" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pessoa->complemento ?? "" ?>">
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="bairro">Bairro: *</label>
                                            <input type="text" class="form-control" name="en_bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pessoa->bairro ?? ""?>" readonly>
                                        </div>
                                        <div class="form-group col-2">
                                            <label for="cidade">Cidade: *</label>
                                            <input type="text" class="form-control" name="en_cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pessoa->cidade ?? "" ?>" readonly>
                                        </div>
                                        <div class="form-group col-1">
                                            <label for="estado">Estado: *</label>
                                            <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pessoa->uf ?? "" ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                                <!--<editor-fold desc="Parentesco">-->
                                <div class="tab-pane fade" id="custom-tabs-one-parentesco" role="tabpanel" aria-labelledby="custom-tabs-one-parentesco-tab">
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="conjuge_nome">Nome do cônjuge:</label>
                                            <input type="text" class="form-control" id="conjuge_nome" name="co_conjuge_nome" maxlength="70" value="<?= $pessoa->conjuge_nome ?? null ?>">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="pf_quantidade_dependente">Quantidade dependente:</label>
                                            <input type="number" class="form-control" name="pf_quantidade_dependente" id="pf_quantidade_dependente" min="0" maxlength="2" value="<?= $pessoa->quantidade_dependente ?? "" ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="nome_mae">Nome da mãe:</label>
                                            <input type="text" class="form-control" id="nome_mae" name="ma_nome_mae" maxlength="70" value="<?= $pessoa->nome_mae ?? null ?>">
                                        </div>
                                        <div class="form-group col">
                                            <label for="nome_pai">Nome do pai:</label>
                                            <input type="text" class="form-control" id="nome_pai" name="pa_nome_pai" maxlength="70" value="<?= $pessoa->nome_pai ?? null ?>">
                                        </div>
                                    </div>
                                </div>
                                <!--</editor-fold>-->
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?= SERVERURL ?>pessoa/<?= $link ?? "funcionario_ativo_lista" ?>" class="btn btn-default pull-left">
                                Voltar
                            </a>
                            <?php if ($_SESSION['profile_tc'] != 3): // 3-leitor ?>
                                <button type="submit" class="btn btn-primary float-right">Gravar</button>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script src="../views/dist/js/cep_api.js"></script>

<script type="application/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    })
</script>