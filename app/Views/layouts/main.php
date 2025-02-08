<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'VelezCRM' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Phoenix Theme -->
    <link href="<?= APP_URL ?>/assets/css/theme.min.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/assets/css/custom.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php require_once VIEW_PATH . '/templates/navbar.php'; ?>

    <!-- Sidebar -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php require_once VIEW_PATH . '/templates/sidebar.php'; ?>
    <?php endif; ?>

    <!-- Conteúdo Principal -->
    <main class="main-content">
        <div class="container-fluid">
            <?php if (isset($pageTitle)): ?>
                <h1 class="mb-4"><?= $pageTitle ?></h1>
            <?php endif; ?>
            
            <!-- Conteúdo da View -->
            <?php require_once VIEW_PATH . "/{$view}.php"; ?>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/theme.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/custom.js"></script>
</body>
</html>
