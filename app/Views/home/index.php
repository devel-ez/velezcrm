<?php
/**
 * Página inicial do dashboard
 * Exibe os principais indicadores e atividades recentes
 */
?>

<!-- Cards de Resumo -->
<div class="row g-3 mb-3">
    <!-- Total de Serviços -->
    <div class="col-md-6 col-xxl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-1">Total de Serviços</h5>
                        <h3 class="mb-0 text-primary"><?= $totalServices ?? 0 ?></h3>
                    </div>
                    <div class="pe-3">
                        <span class="text-primary" data-feather="settings" style="width: 40px; height: 40px;"></span>
                    </div>
                </div>
                <a href="<?= APP_URL ?>/servicos" class="fw-semi-bold fs--1 text-nowrap">Ver todos
                    <span class="fas fa-angle-right ms-1"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Contratos Ativos -->
    <div class="col-md-6 col-xxl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-1">Contratos Ativos</h5>
                        <h3 class="mb-0 text-success"><?= $totalContracts ?? 0 ?></h3>
                    </div>
                    <div class="pe-3">
                        <span class="text-success" data-feather="file-text" style="width: 40px; height: 40px;"></span>
                    </div>
                </div>
                <a href="<?= APP_URL ?>/contratos" class="fw-semi-bold fs--1 text-nowrap">Ver todos
                    <span class="fas fa-angle-right ms-1"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Tarefas Pendentes -->
    <div class="col-md-6 col-xxl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-1">Tarefas Pendentes</h5>
                        <h3 class="mb-0 text-warning"><?= $totalTasks ?? 0 ?></h3>
                    </div>
                    <div class="pe-3">
                        <span class="text-warning" data-feather="check-square" style="width: 40px; height: 40px;"></span>
                    </div>
                </div>
                <a href="<?= APP_URL ?>/kanban" class="fw-semi-bold fs--1 text-nowrap">Ver todas
                    <span class="fas fa-angle-right ms-1"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Total de Clientes -->
    <div class="col-md-6 col-xxl-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-1">Total de Clientes</h5>
                        <h3 class="mb-0 text-info"><?= $totalClients ?? 0 ?></h3>
                    </div>
                    <div class="pe-3">
                        <span class="text-info" data-feather="users" style="width: 40px; height: 40px;"></span>
                    </div>
                </div>
                <a href="<?= APP_URL ?>/clientes" class="fw-semi-bold fs--1 text-nowrap">Ver todos
                    <span class="fas fa-angle-right ms-1"></span>
                </a>
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
        <?php if (empty($recentActivities)): ?>
            <div class="text-center py-5">
                <span class="text-muted" data-feather="clock" style="width: 40px; height: 40px;"></span>
                <p class="mt-3">Nenhuma atividade recente para exibir.</p>
            </div>
        <?php else: ?>
            <div class="timeline-vertical py-0">
                <?php foreach ($recentActivities as $activity): ?>
                    <div class="timeline-item timeline-item-start">
                        <div class="timeline-icon icon-item icon-item-sm rounded-7 shadow-none bg-200">
                            <i class="fas fa-circle text-primary fs--2"></i>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 timeline-item-time">
                                <div>
                                    <p class="fs--1 mb-0 fw-semi-bold"><?= $activity['date'] ?></p>
                                    <p class="fs--2 text-600"><?= $activity['time'] ?></p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="timeline-item-content">
                                    <div class="timeline-item-card">
                                        <h5 class="mb-2"><?= $activity['title'] ?></h5>
                                        <p class="fs--1 mb-0"><?= $activity['description'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
