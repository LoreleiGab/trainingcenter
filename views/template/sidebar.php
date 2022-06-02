<?php

use TrainingCenter\Controllers\ViewsController;

$view = new ViewsController();

    $nomeUser = explode(' ', $_SESSION['nome_tc'])[0];

?>
<!-- Brand Logo -->
<a href="<?= SERVERURL ?>inicio" class="brand-link">
    <img src="<?= SERVERURL ?>views/dist/img/logo.png" alt="GesP Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= NOMESIS ?></span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="<?= SERVERURL ?>inicio/edita" class="d-block">Olá, <?= $nomeUser ?>!</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <?php
            $menuTitulo = explode("/", $_GET['views']);
//            echo "<li class='nav-header'>".strtoupper($menuTitulo['0'])."</li>";
            $menu = $view->exibirMenuController();
            if ($menu == 'login') {
                include "./views/template/menuExemplo.php";
            } else {
                include $menu;
            }
            ?>
            <?php if ($_SESSION['profile_tc'] == 1) : ?>
                <li class="nav-header">ADMINISTRATIVO</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>
                            Gerenciar sistema
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= SERVERURL ?>administrativo/local_dor_lista" class="nav-link" id="local_dor_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Local da dor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= SERVERURL ?>administrativo/membro_lista" class="nav-link" id="membro_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Membro dominante</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= SERVERURL ?>administrativo/grupo_tipo_lista" class="nav-link" id="grupo_tipo_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tipo de Grupo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= SERVERURL ?>administrativo/usuario_lista" class="nav-link" id="usuario_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usuários</p>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            <li class="nav-header">PESSOAS</li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-user-tie"></i>
                    <p>
                        Funcionários
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= SERVERURL ?>pessoa/funcionario_ativo_lista" class="nav-link" id="funcionario_ativo_lista">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ativo</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SERVERURL ?>pessoa/funcionario_cedido_lista" class="nav-link" id="funcionario_cedido_lista">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cedido</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SERVERURL ?>pessoa/funcionario_inativo_lista" class="nav-link" id="funcionario_inativo_lista">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inativo</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>pessoa/ferias_lista" class="nav-link" id="ferias_lista">
                    <i class="fas fa-umbrella-beach"></i>
                    <p>Férias</p>
                </a>
            </li>

            <li class="nav-header">CONTA</li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>inicio/edita" class="nav-link">
                    <i class="fa fa-user"></i> 
                    <p>Minha conta</p>
                </a>
            </li>
            <!--<li class="nav-item">
                <a href="http://smcsistemas.prefeitura.sp.gov.br/manual/siscontrat" target="_blank" class="nav-link">
                    <i class="fa fa-question"></i>&nbsp;
                    <p>Ajuda</p>
                </a>
            </li>-->
            <li class="nav-item">
                <a href="<?= SERVERURL ?>inicio/logout" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>&nbsp; <p>Sair</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->

<?= $view->retornaMenuAtivo() ?>