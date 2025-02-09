<?php
// Verifica se há mensagem flash para exibir
if (isset($flash)): ?>
    <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $flash['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?php echo isset($cliente) ? 'Editar Cliente' : 'Novo Cliente'; ?></h3>
            </div>
            <div class="card-body">
                <form id="formCliente" action="<?php echo BASE_URL . '/clientes/salvar'; ?>" method="POST">
                    <?php if (isset($cliente) && isset($cliente['id'])): ?>
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($cliente['id']); ?>">
                    <?php endif; ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" class="form-control" id="nome" name="nome" required 
                                   value="<?php echo isset($cliente['nome']) ? htmlspecialchars($cliente['nome']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="telefone" class="form-label">Telefone *</label>
                            <input type="text" class="form-control telefone" id="telefone" name="telefone" required
                                   value="<?php echo isset($cliente['telefone']) ? htmlspecialchars($cliente['telefone']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control" id="empresa" name="empresa"
                                   value="<?php echo isset($cliente['empresa']) ? htmlspecialchars($cliente['empresa']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" class="form-control cnpj" id="cnpj" name="cnpj"
                                   value="<?php echo isset($cliente['cnpj']) ? htmlspecialchars($cliente['cnpj']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="login_hospedagem" class="form-label">Login Hospedagem</label>
                            <input type="text" class="form-control" id="login_hospedagem" name="login_hospedagem"
                                   value="<?php echo isset($cliente['login_hospedagem']) ? htmlspecialchars($cliente['login_hospedagem']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="senha_hospedagem" class="form-label">Senha Hospedagem</label>
                            <input type="text" class="form-control" id="senha_hospedagem" name="senha_hospedagem"
                                   value="<?php echo isset($cliente['senha_hospedagem']) ? htmlspecialchars($cliente['senha_hospedagem']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="login_wp" class="form-label">Login WordPress</label>
                            <input type="text" class="form-control" id="login_wp" name="login_wp"
                                   value="<?php echo isset($cliente['login_wp']) ? htmlspecialchars($cliente['login_wp']) : ''; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="senha_wp" class="form-label">Senha WordPress</label>
                            <input type="text" class="form-control" id="senha_wp" name="senha_wp"
                                   value="<?php echo isset($cliente['senha_wp']) ? htmlspecialchars($cliente['senha_wp']) : ''; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="ativo" <?php echo (!isset($cliente['status']) || $cliente['status'] == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                                    <option value="pendente" <?php echo (isset($cliente['status']) && $cliente['status'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                    <option value="inativo" <?php echo (isset($cliente['status']) && $cliente['status'] == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3"><?php echo isset($cliente['observacoes']) ? htmlspecialchars($cliente['observacoes']) : ''; ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar
                        </button>
                        <a href="<?php echo BASE_URL . '/clientes'; ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Certifique-se de que o IMask está incluído no layout -->
<script src="https://unpkg.com/imask"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para telefone
    const telefoneInput = document.querySelector('.telefone');
    if (telefoneInput) {
        IMask(telefoneInput, {
            mask: '(00) 00000-0000'
        });
    }

    // Máscara para CNPJ
    const cnpjInput = document.querySelector('.cnpj');
    if (cnpjInput) {
        IMask(cnpjInput, {
            mask: '00.000.000/0000-00'
        });
    }

    // Validação e envio do formulário
    const form = document.getElementById('formCliente');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar campos obrigatórios
        const nome = document.getElementById('nome').value.trim();
        const telefone = document.getElementById('telefone').value.trim();
        
        if (!nome || !telefone) {
            alert('Por favor, preencha os campos obrigatórios (Nome e Telefone).');
            return;
        }
        
        // Se passou pela validação, envia o formulário
        this.submit();
    });
});</script>
