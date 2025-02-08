<?php
/**
 * Componente da Barra de Navegação
 * Inclui o logo, menu do usuário e notificações
 */
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="<?= APP_URL ?>">
            <img src="<?= APP_URL ?>/assets/img/logo.png" alt="VelezCRM" height="30">
        </a>

        <!-- Menu do usuário -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown">
                    <i class="fas fa-user"></i>
                    <?= $_SESSION['user_name'] ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="<?= APP_URL ?>/profile">Meu Perfil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= APP_URL ?>/auth/logout">Sair</a></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>
