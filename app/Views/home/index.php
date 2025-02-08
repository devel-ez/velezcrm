<!-- Cards de Resumo -->
<div class="row g-3 mb-3">
    <div class="col-sm-6 col-md-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"></div>
            <div class="card-body position-relative">
                <h6>Total de Clientes</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-warning"><?= $totalClients ?></div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= APP_URL ?>/clientes">Ver todos<span class="fas fa-angle-right ms-1"></span></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"></div>
            <div class="card-body position-relative">
                <h6>Total de Serviços</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-info"><?= $totalServices ?></div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= APP_URL ?>/servicos">Ver todos<span class="fas fa-angle-right ms-1"></span></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"></div>
            <div class="card-body position-relative">
                <h6>Contratos Ativos</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-success"><?= $totalContracts ?></div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= APP_URL ?>/contratos">Ver todos<span class="fas fa-angle-right ms-1"></span></a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3">
        <div class="card overflow-hidden" style="min-width: 12rem">
            <div class="bg-holder bg-card"></div>
            <div class="card-body position-relative">
                <h6>Tarefas Pendentes</h6>
                <div class="display-4 fs-4 mb-2 fw-normal font-sans-serif text-primary"><?= $totalTasks ?></div>
                <a class="fw-semi-bold fs--1 text-nowrap" href="<?= APP_URL ?>/kanban">Ver todas<span class="fas fa-angle-right ms-1"></span></a>
            </div>
        </div>
    </div>
</div>

<!-- Seção de Boas-vindas -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row g-0">
            <div class="col-12">
                <h3 class="text-primary">Bem-vindo ao VelezCRM!</h3>
                <p class="mb-0">Este é seu painel de controle. Aqui você pode:</p>
                <ul class="list-unstyled mt-3">
                    <li><i class="fas fa-check text-success me-2"></i> Gerenciar seus clientes</li>
                    <li><i class="fas fa-check text-success me-2"></i> Controlar serviços e contratos</li>
                    <li><i class="fas fa-check text-success me-2"></i> Acompanhar tarefas no Kanban</li>
                    <li><i class="fas fa-check text-success me-2"></i> Visualizar relatórios e métricas</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Atividades Recentes -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Atividades Recentes</h5>
    </div>
    <div class="card-body">
        <div class="text-center py-4">
            <i class="fas fa-clock fa-3x text-muted mb-3"></i>
            <p class="text-muted">Nenhuma atividade recente para exibir.</p>
        </div>
    </div>
</div>
