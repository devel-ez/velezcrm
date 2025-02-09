<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4">Contratos</h1>
        <a href="<?php echo BASE_URL; ?>/contratos/novo" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Contrato
        </a>
    </div>

    <?php require_once __DIR__ . '/../includes/flash-messages.php'; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-contract me-1"></i>
            Lista de Contratos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="contratos-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Cliente</th>
                            <th>Data de Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($contratos)): ?>
                            <?php foreach ($contratos as $contrato): ?>
                                <tr>
                                    <td><?php echo $contrato['id']; ?></td>
                                    <td><?php echo htmlspecialchars($contrato['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($contrato['cliente_nome']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($contrato['created_at'])); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo BASE_URL; ?>/contratos/editar/<?php echo $contrato['id']; ?>" 
                                               class="btn btn-primary btn-sm" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/contratos/excluir/<?php echo $contrato['id']; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Tem certeza que deseja excluir este contrato?')"
                                               title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhum contrato encontrado.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa o DataTable
    $('#contratos-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
        },
        order: [[0, 'desc']]
    });
});
</script>
