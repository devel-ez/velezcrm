<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    
    <!-- Phoenix CSS -->
    <link href="https://prium.github.io/phoenix/v1.20.1/assets/css/theme.min.css" rel="stylesheet" id="style-default">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row min-vh-100 flex-center g-0">
            <div class="col-lg-8 col-xxl-5 py-3 position-relative">
                <div class="card overflow-hidden z-1">
                    <div class="card-body p-0">
                        <div class="row g-0 h-100">
                            <div class="col-md-5 text-center bg-card-gradient">
                                <div class="position-relative p-4 pt-md-5 pb-md-7">
                                    <div class="bg-holder bg-auth-card-shape"></div>
                                    <div class="z-1 position-relative">
                                        <h4 class="text-white mb-2">VelezCRM</h4>
                                        <p class="text-white-50">Sistema de Gestão de Relacionamento com o Cliente</p>
                                    </div>
                                </div>
                                <div class="mt-3 mb-4 mt-md-4 mb-md-5">
                                    <p class="text-white-50">Não tem uma conta?<br/>Entre em contato com o administrador</p>
                                </div>
                            </div>
                            <div class="col-md-7 d-flex flex-center">
                                <div class="p-4 p-md-5 flex-grow-1">
                                    <div class="text-center text-md-start">
                                        <h4 class="mb-0">Bem-vindo!</h4>
                                        <p class="mb-4">Faça login para acessar sua conta</p>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-sm-8 col-md">
                                            <form method="post" action="<?= APP_URL ?>/auth/login">
                                                <div class="mb-3">
                                                    <label class="form-label" for="email">Email</label>
                                                    <input class="form-control" type="email" id="email" name="email" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="password">Senha</label>
                                                    <input class="form-control" type="password" id="password" name="password" required />
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                                                        <label class="form-check-label" for="remember">Lembrar-me</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <button class="btn btn-primary d-block w-100" type="submit">Entrar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
