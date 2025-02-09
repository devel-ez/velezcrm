<?php

/**
 * Componente da Barra de Navegação
 * Inclui o logo, menu do usuário e notificações
 */
?>
<nav class="navbar navbar-top fixed-top navbar-expand navbar-darker" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">
            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggle-icon">
                    <span class="toggle-line"></span>
                </span>
            </button>
            <a class="navbar-brand me-1 me-sm-3" href="<?= APP_URL ?>">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?= APP_URL ?>/public/assets/images/logo.png" alt="VelezCRM" width="32" height="32">
                        <p class="logo-text ms-2 d-none d-sm-block mb-0 text-white">VelezCRM</p>
                    </div>
                </div>
            </a>
        </div>

        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
                <button id="theme-toggle" class="btn btn-link text-white" aria-label="Toggle theme">
                    <i class="fas fa-adjust"></i>
                </button>
            </li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Notificações -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="text-700" data-feather="bell"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border border-300 navbar-dropdown-caret" id="navbarDropdownNotification">
                        <div class="card position-relative border-0">
                            <div class="card-header p-2">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 text-white">Notificações</h5>
                                    <button class="btn btn-link p-0 fs--1 fw-normal text-white" type="button">Marcar todas como lidas</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="text-center py-5">
                                    <span class="text-600" data-feather="bell-off" style="width: 30px; height: 30px;"></span>
                                    <p class="mt-2">Nenhuma notificação</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- Menu do Usuário -->
                <li class="nav-item dropdown">
                    <a class="nav-link lh-1 pe-0 white-link" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-l">
                            <img class="rounded-circle" src="<?= APP_URL ?>/public/assets/images/admin.png" alt="<?= $_SESSION['user_name'] ?>">
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300" aria-labelledby="navbarDropdownUser">
                        <div class="card position-relative border-0">
                            <div class="card-body p-0">
                                <div class="text-center pt-4 pb-3">
                                    <div class="avatar avatar-xl">
                                        <img class="rounded-circle" src="<?= APP_URL ?>/public/assets/images/admin.png" alt="<?= $_SESSION['user_name'] ?>">
                                    </div>
                                    <h6 class="mt-2 text-white"><?= $_SESSION['user_name'] ?></h6>
                                </div>
                            </div>
                            <div class="overflow-auto scrollbar">
                                <ul class="nav d-flex flex-column mb-2 pb-1">
                                    <li class="nav-item">
                                        <a class="nav-link px-3" href="<?= APP_URL ?>/profile">
                                            <span class="me-2 text-900" data-feather="user"></span>
                                            Meu Perfil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-3" href="<?= APP_URL ?>/settings">
                                            <span class="me-2 text-900" data-feather="settings"></span>
                                            Configurações
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <hr class="my-2">
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-3" href="<?= APP_URL ?>/auth/logout">
                                            <span class="me-2 text-900" data-feather="log-out"></span>
                                            Sair
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>