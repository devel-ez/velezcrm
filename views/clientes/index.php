<?php if (isset($flash)): ?>
    <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $flash['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Clientes</h2>
    <a href="<?php echo BASE_URL; ?>/clientes/novo" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Novo Cliente
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Empresa</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum cliente cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo $cliente['id']; ?></td>
                                <td><?php echo htmlspecialchars($cliente['nome']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['empresa'] ?? ''); ?></td>
                                <td>
                                    <?php
                                    switch ($cliente['status']) {
                                        case 'ativo':
                                            $statusClass = 'success';
                                            $statusText = 'Ativo';
                                            break;
                                        case 'pendente':
                                            $statusClass = 'warning';
                                            $statusText = 'Pendente';
                                            break;
                                        case 'inativo':
                                            $statusClass = 'danger';
                                            $statusText = 'Inativo';
                                            break;
                                        default:
                                            $statusClass = 'secondary';
                                            $statusText = ucfirst($cliente['status']);
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $statusClass; ?>">
                                        <?php echo $statusText; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?php echo BASE_URL; ?>/clientes/editar/<?php echo $cliente['id']; ?>"
                                            class="btn btn-sm btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/clientes/visualizar/<?php echo $cliente['id']; ?>"
                                            class="btn btn-sm btn-secondary" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-sm btn-danger"
                                            onclick="showConfirmModal(<?php echo $cliente['id']; ?>); return false;"
                                            title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação para Exclusão -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Os contratos vinculados a este cliente também serão excluídos. Deseja continuar?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Sim, Excluir</a>
            </div>
        </div>
    </div>
</div>

<script>
    function showConfirmModal(clienteId) {
        // Define o link de exclusão dinamicamente
        document.getElementById("confirmDeleteButton").href = "<?php echo BASE_URL; ?>/clientes/excluir/" + clienteId;

        // Exibe o modal de confirmação
        var deleteModal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"));
        deleteModal.show();
    }
</script>