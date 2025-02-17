<?php if (isset($flash)): ?>
    <div class="alert alert-<?= $flash['tipo'] ?> alert-dismissible fade show" role="alert">
        <?= $flash['mensagem'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary"><i class="fas fa-users-cog"></i> Gerenciamento de Usuários</h2>
        <a href="/configuracoes/novo" class="btn btn-success"><i class="fas fa-user-plus"></i> Adicionar Novo</a>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                <td><?= htmlspecialchars($usuario['email']) ?></td>
                                <td><span class="badge bg-info"><?= ucfirst(htmlspecialchars($usuario['tipo'])) ?></span></td>
                                <td>
                                    <?php if ($usuario['status'] == 'ativo'): ?>
                                        <span class="badge bg-success">Ativo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inativo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="/configuracoes/editar/<?= $usuario['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <button class="btn btn-danger btn-sm" onclick="confirmarExclusao(<?= $usuario['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i> Excluir
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum usuário cadastrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de Confirmação para Exclusão -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalExcluirLabel"><i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este usuário? Essa ação não pode ser desfeita.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formExcluir" method="POST" action="/configuracoes/excluir">
                    <input type="hidden" name="id" id="userIdExcluir">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para abrir o modal de exclusão -->
<script>
    function confirmarExclusao(userId) {
        document.getElementById('userIdExcluir').value = userId;
        var modal = new bootstrap.Modal(document.getElementById('modalExcluir'));
        modal.show();
    }
</script>