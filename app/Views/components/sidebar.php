<?php
/**
 * Componente da Barra Lateral
 * Contém o menu principal de navegação
 */
?>
<nav class="navbar navbar-vertical navbar-expand-lg navbar-darker">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <div class="navbar-vertical-content">
            <div class="navbar-vertical-content scrollbar">
                <ul class="navbar-nav flex-column mt-8" id="navbarVerticalNav">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link <?= $view === 'home/index' ? 'active' : '' ?>" href="<?= APP_URL ?>" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="home"></span>
                                </span>
                                <span class="nav-link-text">Dashboard</span>
                            </div>
                        </a>
                    </li>

                    <!-- Clientes -->
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($view, 'clients/') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>/clients" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="users"></span>
                                </span>
                                <span class="nav-link-text">Clientes</span>
                            </div>
                        </a>
                    </li>

                    <!-- Serviços -->
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($view, 'services/') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>/services" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="settings"></span>
                                </span>
                                <span class="nav-link-text">Serviços</span>
                            </div>
                        </a>
                    </li>

                    <!-- Contratos -->
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($view, 'contracts/') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>/contracts" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="file-text"></span>
                                </span>
                                <span class="nav-link-text">Contratos</span>
                            </div>
                        </a>
                    </li>

                    <!-- Kanban -->
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($view, 'kanban/') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>/kanban" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="trello"></span>
                                </span>
                                <span class="nav-link-text">Kanban</span>
                            </div>
                        </a>
                    </li>

                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <!-- Configurações (apenas admin) -->
                        <li class="nav-item">
                            <a class="nav-link <?= strpos($view, 'settings/') === 0 ? 'active' : '' ?>" href="<?= APP_URL ?>/settings" role="button" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span data-feather="settings"></span>
                                    </span>
                                    <span class="nav-link-text">Configurações</span>
                                </div>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- Collapsed View Button -->
        <div class="navbar-vertical-footer">
            <button class="btn navbar-vertical-toggle border-0 w-100 white-link py-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="me-2" data-feather="chevrons-left"></span>
                <span>Recolher</span>
            </button>
        </div>
    </div>
</nav>
