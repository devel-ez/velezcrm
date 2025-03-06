<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="d-flex justify-content-between align-items-center mb-4">Contratos</h2>
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
                                            <!-- Novo botão para gerar PDF -->
                                            <a href="<?php echo BASE_URL; ?>/contratos/gerarPdf/<?php echo $contrato['id']; ?>" 
                                               class="btn btn-info btn-sm"
                                               target="_blank"
                                               title="Gerar PDF">
                                                <i class="fas fa-file-pdf"></i>
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
$(document).ready(function() {
    $('#contratos-table').DataTable({
        language: {
            "emptyTable": "Nenhum registro encontrado",
            "info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 até 0 de 0 registros",
            "infoFiltered": "(Filtrados de _MAX_ registros)",
            "infoThousands": ".",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "zeroRecords": "Nenhum registro encontrado",
            "search": "Pesquisar",
            "paginate": {
                "next": "Próximo",
                "previous": "Anterior",
                "first": "Primeiro",
                "last": "Último"
            },
            "lengthMenu": "Exibir _MENU_ resultados por página"
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        responsive: true
    });
});
</script>
