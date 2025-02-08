<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página não encontrada - <?= APP_NAME ?></title>
    
    <!-- Phoenix CSS -->
    <link href="https://prium.github.io/phoenix/v1.20.1/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 flex-center g-0">
            <div class="col-11 col-sm-10 col-xl-8">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <img class="d-block mx-auto mb-4" src="https://prium.github.io/phoenix/v1.20.1/assets/img/icons/spot-illustrations/404.png" alt="404" width="200">
                            <h2 class="mb-3">Página não encontrada!</h2>
                            <p class="text-800 mb-4">A página que você está procurando não existe ou foi movida.</p>
                            <a class="btn btn-primary" href="<?= APP_URL ?>">
                                <i class="fas fa-home me-2"></i>Voltar para o início
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Phoenix JavaScript -->
    <script src="https://prium.github.io/phoenix/v1.20.1/assets/js/phoenix.js"></script>
</body>
</html>
