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
                            <a href="<?= SERVERURL ?>administrativo/modalidade_lista" class="nav-link" id="modalidade_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Modalidade</p>
                            </a>
                        </li>

                        <li class="nav-item">   
                            <a href="<?= SERVERURL ?>administrativo/posicao_lista" class="nav-link" id="posicao_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Posição</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?= SERVERURL ?>administrativo/horas_dormidas_lista" class="nav-link" id="horas_dormidas_lista">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Horas Dormidas</p>
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

            <li class="nav-header">PREPARADOR</li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>preparador/atleta_lista" class="nav-link" id="atleta_lista">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Atleta</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>preparador/assimetria_lista" class="nav-link" id="assimetria_lista">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Teste de força</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>preparador/equipe_lista" class="nav-link" id="equipe_lista">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Equipe</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>preparador/grupo_lista" class="nav-link" id="grupo_lista">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Grupo</p>
                </a>
            </li>

            <li class="nav-header">ATLETA</li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>atleta/esforco_lista" class="nav-link" id="esforco_lista">
                    <i class="far fa-circle nav-icon"></i>
                    <p>PSE – Esforço</p>
                </a>
            </li>

            <li class="nav-header">CONTA</li>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>inicio/edita" class="nav-link">
                    <i class="fa fa-user"></i>&nbsp;&nbsp;
                    <p>Minha conta</p>
                </a>
            </li>
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