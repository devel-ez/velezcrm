<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VelezCRM - <?php echo $pageTitle ?? 'Sistema de Gestão'; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* Tema Claro */
        [data-bs-theme="light"] {
            --bg-primary: #f0f2f5;
            --bg-secondary: #ffffff;
            --text-primary: #111827;
            --text-secondary: #374151;
            --border-color: #d1d5db;
            --hover-bg: #3a4654;
            --link-color: #2563eb;
            --link-hover: #1d4ed8;
            --card-shadow: 0 2px 4px rgba(0,0,0,0.1);
            --header-bg: #ffffff;
        }
        
        /* Ajustes específicos para tema claro */
        [data-bs-theme="light"] .navbar-vertical {
            background: #2a3441;
            border-right: 1px solid #3a4654;
        }
        
        [data-bs-theme="light"] .navbar-brand {
            border-bottom: 1px solid #3a4654;
        }
        
        [data-bs-theme="light"] .brand-text {
            color: #ffffff;
        }
        
        [data-bs-theme="light"] .nav-link {
            color: #a3b2c7 !important;
        }
        
        [data-bs-theme="light"] .nav-link:hover,
        [data-bs-theme="light"] .nav-link.active {
            color: #ffffff !important;
            background: #3a4654;
        }
        
        [data-bs-theme="light"] .sidebar-collapse .navbar-vertical {
            background: #2a3441;
        }
        
        /* Tema Escuro */
        [data-bs-theme="dark"] {
            --bg-primary: #1e2936;
            --bg-secondary: #2a3441;
            --text-primary: #ffffff;
            --text-secondary: #a3b2c7;
            --border-color: #3a4654;
            --hover-bg: #3a4654;
            --link-color: #60a5fa;
            --link-hover: #3b82f6;
            --card-shadow: 0 2px 4px rgba(0,0,0,0.2);
            --header-bg: #2a3441;
        }
        
        /* Ajustes específicos para tema escuro */
        [data-bs-theme="dark"] .navbar-vertical {
            background: #2a3441;
            border-right: 1px solid #3a4654;
        }
        
        [data-bs-theme="dark"] .card {
            background: #2a3441;
            border: 1px solid #3a4654;
        }
        
        [data-bs-theme="dark"] .table {
            color: #a3b2c7;
        }
        
        [data-bs-theme="dark"] .table thead th {
            color: #ffffff;
            border-bottom-color: #3a4654;
            background-color: #2a3441;
        }
        
        [data-bs-theme="dark"] .table td {
            border-color: #3a4654;
        }
        
        [data-bs-theme="dark"] .dropdown-menu {
            background: #2a3441;
            border: 1px solid #3a4654;
        }
        
        [data-bs-theme="dark"] .dropdown-item {
            color: #a3b2c7;
        }
        
        [data-bs-theme="dark"] .dropdown-item:hover {
            background: #3a4654;
            color: #ffffff;
        }
        
        [data-bs-theme="dark"] .dropdown-divider {
            border-color: #3a4654;
        }
        
        [data-bs-theme="dark"] .theme-toggle {
            background: #2a3441;
            border: 1px solid #3a4654;
            color: #a3b2c7;
        }
        
        [data-bs-theme="dark"] .theme-toggle:hover {
            background: #3a4654;
            color: #ffffff;
        }
        
        [data-bs-theme="dark"] .nav-link {
            color: #a3b2c7 !important;
        }
        
        [data-bs-theme="dark"] .nav-link:hover,
        [data-bs-theme="dark"] .nav-link.active {
            color: #ffffff !important;
            background: #3a4654;
        }
        
        /* Ajustes dos gráficos no tema escuro */
        [data-bs-theme="dark"] .progress {
            background-color: #3a4654;
        }
        
        [data-bs-theme="dark"] .timeline-item {
            background-color: #2a3441;
            border: 1px solid #3a4654;
        }
        
        [data-bs-theme="dark"] .timeline-header {
            border-bottom: 1px solid #3a4654;
        }
        
        /* Cores dos cards de estatísticas */
        .bg-info { background-color: #0284c7 !important; }
        .bg-success { background-color: #059669 !important; }
        .bg-warning { background-color: #d97706 !important; }
        .bg-danger { background-color: #dc2626 !important; }
        
        .table {
            color: var(--text-secondary);
        }
        
        .table thead th {
            border-bottom-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .table td {
            border-bottom-color: var(--border-color);
        }
        
        .theme-toggle {
            padding: 8px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .theme-toggle:hover {
            background: var(--hover-bg);
            color: #fff;
        }
        
        /* Adiciona estilo para o sidebar recolhido */
        body.sidebar-collapse .navbar-vertical {
            width: 4.6rem;
            z-index: 1021;
        }
        
        body.sidebar-collapse .content {
            margin-left: 4.6rem;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link p,
        body.sidebar-collapse .navbar-vertical .brand-text {
            display: none;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link {
            padding: 12px;
            margin: 4px 8px;
            text-align: center;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link i {
            margin: 0;
            font-size: 1.2rem;
        }
        
        /* Transição suave ao recolher/expandir */
        .navbar-vertical,
        .content,
        .nav-link,
        .nav-link p,
        .brand-text {
            transition: all 0.3s ease-in-out;
        }
        
        /* Estilo do botão push menu */
        .push-menu-btn {
            padding: 8px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            margin-right: 1rem;
        }
        
        .push-menu-btn:hover {
            background: var(--hover-bg);
            color: #fff;
        }
        
        body {
            background-color: var(--bg-primary);
            color: var(--text-secondary);
            min-height: 100vh;
            transition: all 0.3s ease;
        }
        
        .navbar-vertical {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background: var(--bg-secondary);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
            background-color: var(--bg-primary);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .brand-text {
            font-size: 1.25rem;
            font-weight: 500;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            margin: 2px 15px;
            border-radius: 8px;
            transition: all 0.3s;
            color: var(--text-secondary) !important;
        }
        
        .nav-link i {
            width: 1.5rem;
            text-align: center;
            margin-right: 0.5rem;
            font-size: 1rem;
        }
        
        .nav-link p {
            margin: 0;
            font-size: 0.9rem;
            font-weight: 400;
        }
        
        /* Ajustes quando o menu está recolhido */
        body.sidebar-collapse .navbar-vertical {
            width: 4.6rem;
        }
        
        body.sidebar-collapse .content {
            margin-left: 4.6rem;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link {
            padding: 0.8rem;
            margin: 2px 8px;
            justify-content: center;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link i {
            margin: 0;
            width: auto;
        }
        
        h2 {
            font-size: 1.5rem;
            font-weight: 500;
            color: var(--text-primary);
        }
        
        h3 {
            font-size: 1.25rem;
            font-weight: 500;
        }
        
        .card-title {
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 0;
        }
        
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
        }
        
        .small-box {
            position: relative;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            color: #fff;
            transition: all 0.3s;
            overflow: hidden;
        }
        
        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .small-box .inner {
            position: relative;
            z-index: 2;
        }
        
        .small-box .icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 50px;
            opacity: 0.3;
            z-index: 1;
        }
        
        .small-box h3 {
            font-size: 36px;
            margin: 0;
            font-weight: bold;
            color: #fff;
        }
        
        .small-box p {
            font-size: 14px;
            margin: 5px 0 0;
            color: rgba(255,255,255,0.8);
        }
        
        .small-box .small-box-footer {
            position: relative;
            text-align: center;
            padding: 3px 0;
            color: rgba(255,255,255,0.8);
            display: block;
            background: rgba(0,0,0,0.1);
            text-decoration: none;
            margin: 15px -20px -20px;
        }
        
        .small-box .small-box-footer:hover {
            color: #fff;
            background: rgba(0,0,0,0.2);
        }
        
        .bg-info { background: #0ea5e9 !important; }
        .bg-success { background: #22c55e !important; }
        .bg-warning { background: #eab308 !important; }
        .bg-danger { background: #ef4444 !important; }
        
        .table {
            color: var(--text-secondary);
        }
        
        .table thead th {
            border-bottom-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .table td {
            border-bottom-color: var(--border-color);
        }
        
        .theme-toggle {
            padding: 8px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .theme-toggle:hover {
            background: var(--hover-bg);
            color: #fff;
        }
        
        /* Adiciona estilo para o sidebar recolhido */
        body.sidebar-collapse .navbar-vertical {
            width: 4.6rem;
            z-index: 1021;
        }
        
        body.sidebar-collapse .content {
            margin-left: 4.6rem;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link p,
        body.sidebar-collapse .navbar-vertical .brand-text {
            display: none;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link {
            padding: 12px;
            margin: 4px 8px;
            text-align: center;
        }
        
        body.sidebar-collapse .navbar-vertical .nav-link i {
            margin: 0;
            font-size: 1.2rem;
        }
        
        /* Transição suave ao recolher/expandir */
        .navbar-vertical,
        .content,
        .nav-link,
        .nav-link p,
        .brand-text {
            transition: all 0.3s ease-in-out;
        }
        
        /* Estilo do botão push menu */
        .push-menu-btn {
            padding: 8px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            margin-right: 1rem;
        }
        
        .push-menu-btn:hover {
            background: var(--hover-bg);
            color: #fff;
        }
        
        body {
            padding-top: 56px;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .table-responsive {
            margin-top: 20px;
        }
        .dataTables_wrapper {
            padding: 20px;
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
    </style>
</head>
<body class="hold-transition">
    <!-- Menu Lateral -->
    <nav class="navbar-vertical">
        <div class="navbar-brand">
            <a href="<?php echo BASE_URL; ?>" class="text-decoration-none">
                <h3 class="text-primary mb-0 brand-text">VelezCRM</h3>
            </a>
        </div>
        
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/clientes">
                    <i class="fas fa-users me-2"></i>
                    <p>Clientes</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/servicos">
                    <i class="fas fa-cogs me-2"></i>
                    <p>Serviços</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/contratos">
                    <i class="fas fa-file-contract me-2"></i>
                    <p>Contratos</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/kanban">
                    <i class="fas fa-columns me-2"></i>
                    <p>Kanban</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_URL; ?>/configuracoes">
                    <i class="fas fa-cog me-2"></i>
                    <p>Configurações</p>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="content">
        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <!-- Botão Push Menu -->
                <button class="push-menu-btn" id="pushMenu">
                    <i class="fas fa-bars"></i>
                </button>
                
                <h2 class="mb-0" style="color: var(--text-primary);">
                    <?php echo $pageTitle ?? 'Dashboard'; ?>
                </h2>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <!-- Botão de Tema -->
                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-sun"></i>
                </button>
                
                <!-- Notificações -->
                <div class="dropdown">
                    <button class="theme-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">Notificações</div>
                        <a class="dropdown-item" href="#">Nenhuma notificação</a>
                    </div>
                </div>
                
                <!-- Usuário -->
                <div class="dropdown">
                    <button class="theme-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-header">Administrador</div>
                        <a class="dropdown-item" href="#">Perfil</a>
                        <a class="dropdown-item" href="#">Configurações</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Sair</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensagens de Erro -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $erro; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Conteúdo da Página -->
        <?php echo $content; ?>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        // Ativa o item do menu correspondente à página atual
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.nav-link');
            
            menuItems.forEach(item => {
                if (currentPath.includes(item.getAttribute('href'))) {
                    item.classList.add('active');
                }
            });
            
            // Gerenciamento do tema
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            const icon = themeToggle.querySelector('i');
            
            // Carrega o tema salvo
            const savedTheme = localStorage.getItem('theme') || 'dark';
            html.setAttribute('data-bs-theme', savedTheme);
            updateThemeIcon(savedTheme);
            
            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                updateThemeIcon(newTheme);
            });
            
            function updateThemeIcon(theme) {
                icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
            
            // Funcionalidade do Push Menu
            const pushMenu = document.getElementById('pushMenu');
            const body = document.body;
            
            // Carrega o estado do sidebar
            const sidebarState = localStorage.getItem('sidebar-collapsed') === 'true';
            if (sidebarState) {
                body.classList.add('sidebar-collapse');
            }
            
            pushMenu.addEventListener('click', function() {
                body.classList.toggle('sidebar-collapse');
                // Salva o estado do sidebar
                localStorage.setItem('sidebar-collapsed', body.classList.contains('sidebar-collapse'));
            });
        });
    </script>
    <script>
        const BASE_URL = '<?php echo BASE_URL; ?>';
    </script>
</body>
</html>
