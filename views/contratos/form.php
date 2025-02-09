<?php
// Calcula a data de validade padrão (30 dias a partir de hoje)
$dataValidadePadrao = date('Y-m-d', strtotime('+30 days'));
?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-4"><?php echo isset($contrato) ? 'Editar' : 'Novo'; ?> Contrato</h1>
        <a href="<?php echo BASE_URL; ?>/contratos" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <?php require_once __DIR__ . '/../includes/flash-messages.php'; ?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-file-contract me-1"></i>
            Formulário de Contrato
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/contratos/salvar" method="POST">
                <?php if (isset($contrato)): ?>
                    <input type="hidden" name="id" value="<?php echo $contrato['id']; ?>">
                <?php endif; ?>

                <!-- Seção: Informações Básicas -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informações Básicas</h5>
                    </div>
                    <div class="card-body">
                        <!-- Número do Contrato (somente leitura) -->
                        <?php if (isset($contrato) && !empty($contrato['numero_contrato'])): ?>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Número do Contrato</label>
                                <input type="text" class="form-control" value="<?php echo $contrato['numero_contrato']; ?>" readonly>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="titulo" class="form-label">Título do Contrato *</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required
                                       value="<?php echo isset($contrato) ? htmlspecialchars($contrato['titulo']) : ''; ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="data_validade" class="form-label">Data de Validade para Assinatura *</label>
                                <input type="date" class="form-control" id="data_validade" name="data_validade" required
                                       value="<?php echo isset($contrato['data_validade']) ? $contrato['data_validade'] : $dataValidadePadrao; ?>">
                                <div class="form-text">Data limite para assinatura do contrato</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="cliente_id" class="form-label">Cliente *</label>
                                <select class="form-select" id="cliente_id" name="cliente_id" required>
                                    <option value="">Selecione um cliente</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente['id']; ?>" 
                                            <?php echo (isset($contrato) && $contrato['cliente_id'] == $cliente['id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cliente['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção: Objeto e Serviços -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Objeto e Serviços</h5>
                    </div>
                    <div class="card-body">
                        <!-- Objeto do Contrato -->
                        <div class="mb-3">
                            <label for="objeto" class="form-label">Objeto do Contrato *</label>
                            <textarea class="form-control" id="objeto" name="objeto" rows="4" required><?php 
                                echo isset($contrato) ? htmlspecialchars($contrato['objeto']) : ''; 
                            ?></textarea>
                            <div class="form-text">Descreva o objetivo principal e escopo deste contrato</div>
                        </div>

                        <!-- Serviços -->
                        <div class="mb-3">
                            <label class="form-label">Serviços Incluídos</label>
                            <div class="row">
                                <?php foreach ($servicos as $servico): ?>
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="servicos[]" 
                                                   value="<?php echo $servico['id']; ?>" id="servico_<?php echo $servico['id']; ?>"
                                                   <?php echo (isset($servicos_selecionados) && in_array($servico['id'], $servicos_selecionados)) ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="servico_<?php echo $servico['id']; ?>">
                                                <?php echo htmlspecialchars($servico['nome']); ?> - R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="valor" class="form-label">Valor Total (R$)</label>
                            <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0"
                                   value="<?php echo isset($contrato) ? $contrato['valor'] : '0.00'; ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- Seção: Cláusulas -->
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Cláusulas do Contrato</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="clausulas" name="clausulas" rows="15"><?php 
                                echo isset($contrato) ? htmlspecialchars($contrato['clausulas']) : ''; 
                            ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Salvar Contrato
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Carrega o TinyMCE da CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
<!-- Carrega a configuração personalizada do TinyMCE -->
<script src="<?php echo BASE_URL; ?>/assets/js/tinymce-config.js"></script>

<!-- Script para calcular o valor total -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para calcular o valor total
    function calcularValorTotal() {
        let total = 0;
        const checkboxes = document.querySelectorAll('input[name="servicos[]"]:checked');
        
        checkboxes.forEach(function(checkbox) {
            const label = document.querySelector(`label[for="${checkbox.id}"]`);
            const valor = parseFloat(label.textContent.split('R$')[1].trim().replace(',', '.'));
            total += valor;
        });
        
        document.getElementById('valor').value = total.toFixed(2);
    }

    // Adiciona o evento de change em todos os checkboxes
    document.querySelectorAll('input[name="servicos[]"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', calcularValorTotal);
    });

    // Calcula o valor inicial
    calcularValorTotal();
});</script>
