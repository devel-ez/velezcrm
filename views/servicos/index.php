<?php if (isset($flash)): ?>
    <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $flash['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Serviços</h2>
    <a href="<?php echo BASE_URL; ?>/servicos/novo" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Novo Serviço
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
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($servicos)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Nenhum serviço cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($servicos as $servico): ?>
                            <tr>
                                <td><?php echo $servico['id']; ?></td>
                                <td><?php echo htmlspecialchars($servico['nome']); ?></td>
                                <td><?php echo htmlspecialchars($servico['descricao']); ?></td>
                                <td>R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $servico['status'] == 'ativo' ? 'success' : 'danger'; ?>">
                                        <?php echo ucfirst($servico['status']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="<?php echo BASE_URL; ?>/servicos/editar/<?php echo $servico['id']; ?>" class="btn btn-sm btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/servicos/excluir/<?php echo $servico['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este serviço?')" title="Excluir">
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
