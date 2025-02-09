<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'VelezCRM' ?></title>
    
    <!-- Phoenix Theme -->
    <link href="https://prium.github.io/phoenix/v1.20.1/assets/css/theme.min.css" rel="stylesheet">
    <link href="https://prium.github.io/phoenix/v1.20.1/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= APP_URL ?>/public/assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <main class="main" id="top">
        <div class="container-fluid px-0" data-layout="container">
            <!-- Navbar -->
            <?php require_once VIEW_PATH . '/components/navbar.php'; ?>

            <!-- Sidebar -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php require_once VIEW_PATH . '/components/sidebar.php'; ?>
            <?php endif; ?>

            <!-- Conteúdo Principal -->
            <div class="content">
                <!-- Conteúdo -->
                <div class="content-container">
                    <div class="container-fluid pb-3">
                        <?php if (isset($pageTitle)): ?>
                            <nav class="mb-2" aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 mt-3">
                                    <li class="breadcrumb-item"><a href="<?= APP_URL ?>">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle ?></li>
                                </ol>
                            </nav>
                            <div class="mb-4">
                                <h2 class="mb-2"><?= $pageTitle ?></h2>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Conteúdo da View -->
                        <?php require_once VIEW_PATH . "/{$view}.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/popper/popper.min.js"></script>
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/anchorjs/anchor.min.js"></script>
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/is/is.min.js"></script>
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/simplebar/simplebar.min.js"></script>
    <script src="https://prium.github.io/phoenix/v1.20.1/vendors/feather-icons/feather.min.js"></script>
    <script>
        feather.replace();

        // Controle do colapso da sidebar
        const toggleButton = document.querySelector('.navbar-vertical-toggle');
        const navbar = document.querySelector('.navbar-vertical');
        const content = document.querySelector('.content');
        
        // Verificar estado salvo
        const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
        if (isCollapsed) {
            navbar.classList.add('collapsed');
            content.classList.add('collapsed');
        }

        toggleButton.addEventListener('click', () => {
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
            
            // Salvar estado
            localStorage.setItem('sidebarCollapsed', navbar.classList.contains('collapsed'));
        });

        // Alternar tema
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;

        // Verificar tema salvo no localStorage
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            body.setAttribute('data-bs-theme', currentTheme);
        }

        themeToggle.addEventListener('click', () => {
            let theme = body.getAttribute('data-bs-theme');
            theme = (theme === 'dark') ? 'light' : 'dark';
            body.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        });
    </script>
    <script src="https://prium.github.io/phoenix/v1.20.1/assets/js/theme.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/custom.js"></script>
</body>
</html>
