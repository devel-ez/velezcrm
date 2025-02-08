<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= APP_URL ?>/assets/img/favicon.ico" type="image/x-icon">
    
    <!-- Phoenix CSS -->
    <link href="https://prium.github.io/phoenix/v1.20.1/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    
    <!-- Custom CSS -->
    <link href="<?= APP_URL ?>/assets/css/custom.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navbar Vertical -->
    <nav class="navbar navbar-vertical navbar-expand-lg">
        <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
            <!-- Navbar Brand -->
            <div class="navbar-brand d-flex justify-content-center py-3">
                <h3 class="text-primary mb-0">VelezCRM</h3>
            </div>
            
            <!-- Navbar Items -->
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/">
                        <i class="fas fa-home me-2"></i> Painel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/clientes">
                        <i class="fas fa-users me-2"></i> Clientes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/servicos">
                        <i class="fas fa-briefcase me-2"></i> Serviços
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/contratos">
                        <i class="fas fa-file-contract me-2"></i> Contratos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/kanban">
                        <i class="fas fa-tasks me-2"></i> Kanban
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= APP_URL ?>/configuracoes">
                        <i class="fas fa-cog me-2"></i> Configurações
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content"><?php if(isset($pageTitle)): ?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><?= $pageTitle ?></h1>
        </div>
    <?php endif; ?>
