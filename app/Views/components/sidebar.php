<?php
/**
 * Componente da Barra Lateral
 * Contém o menu principal de navegação
 */
?>
<nav class="navbar navbar-vertical navbar-expand-lg navbar-darker">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="<?= APP_URL ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Clientes -->
            <li class="nav-item">
                <a class="nav-link" href="<?= APP_URL ?>/clients">
                    <i class="fas fa-users"></i>
                    <span>Clientes</span>
                </a>
            </li>

            <!-- Serviços -->
            <li class="nav-item">
                <a class="nav-link" href="<?= APP_URL ?>/services">
                    <i class="fas fa-cogs"></i>
                    <span>Serviços</span>
                </a>
            </li>

            <!-- Contratos -->
            <li class="nav-item">
                <a class="nav-link" href="<?= APP_URL ?>/contracts">
                    <i class="fas fa-file-contract"></i>
                    <span>Contratos</span>
                </a>
            </li>

            <!-- Kanban -->
            <li class="nav-item">
                <a class="nav-link" href="<?= APP_URL ?>/kanban">
                    <i class="fas fa-columns"></i>
                    <span>Kanban</span>
                </a>
            </li>

            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <!-- Configurações (apenas admin) -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/settings">
                        <i class="fas fa-cog"></i>
                        <span>Configurações</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
