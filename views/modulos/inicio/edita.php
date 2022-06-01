<?php
$id = $_SESSION['usuario_id_tc'];
require_once "./controllers/UsuarioController.php";
$objUsuario = new UsuarioController();
$usuario = $objUsuario->recuperaUsuario($id)->fetch();

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Minha conta</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados pessoais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body register-card-body">
                        <label>Nome:</label> <?=$usuario['nome_completo']?>
                        <hr>
                        <label>Usuário:</label> <?=$usuario['usuario']?>
                        <hr>
                        <label>E-mail:</label> <?=$usuario['email']?>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Trocar senha</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body register-card-body">
                        <form class="needs-validation formulario-ajax" data-form="update" action="<?=SERVERURL?>ajax/usuarioAjax.php" method="post">
                            <input type="hidden" name="_method" value="trocaSenhaUsuario">
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="senha">Senha: *</label>
                                    <input type="password" class="form-control" id="senha" name="senha" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="senha">Confirme sua senha: *</label>
                                    <input type="password" class="form-control" id="senha2" name="senha2" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-info btn-block btn-flat">Trocar</button>
                            </div>
                            <div class="resposta-ajax">

                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
    const url_local = '<?= $url_local ?>';

    let instituicao = document.querySelector('#instituicao');

    $(document).ready(function () {
        let idInstituicao = $('#instituicao option:checked').val();
        let local_id = <?= $usuario['local_id'] ?>;
        getLocal(idInstituicao, local_id);
    });

    instituicao.addEventListener('change', async e => {
        let idInstituicao = $('#instituicao option:checked').val();
        getLocal(idInstituicao);
    });

    function getLocal(instituicao_id, local_id = false) {
        fetch(`${url_local}?instituicao_id=${instituicao_id}`)
            .then(response => response.json())
            .then(locais => {
                $('#local option').remove();
                $('#local').append('<option value="">Selecione uma opção...</option>');

                for (const local of locais) {
                    if (local.id == local_id) {
                        $('#local').append(`<option value='${local.id}' selected>${local.local}</option>`);
                    } else {
                        $('#local').append(`<option value='${local.id}'>${local.local}</option>`);
                    }
                }
                $('#local').unbind('mousedown');
                $('#local').removeAttr('readonly');

            })
    }
</script>
