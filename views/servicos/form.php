<?php if (isset($flash)): ?>
    <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $flash['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <h2><?php echo isset($servico) ? 'Editar Serviço' : 'Novo Serviço'; ?></h2>
        <form action="<?php echo BASE_URL; ?>/servicos/salvar" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($servico) ? $servico['id'] : ''; ?>">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome *</label>
                <input type="text" class="form-control" id="nome" name="nome" required value="<?php echo isset($servico) ? htmlspecialchars($servico['nome']) : ''; ?>">
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"><?php echo isset($servico) ? htmlspecialchars($servico['descricao']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor *</label>
                <input type="number" class="form-control" id="valor" name="valor" required value="<?php echo isset($servico) ? $servico['valor'] : ''; ?>" step="0.01">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="ativo" <?php echo (isset($servico) && $servico['status'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                    <option value="inativo" <?php echo (isset($servico) && $servico['status'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Salvar
            </button>
            <a href="<?php echo BASE_URL; ?>/servicos" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</div>
