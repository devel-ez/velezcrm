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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;"></th>
                                            <th>Serviço</th>
                                            <th style="width: 200px;" class="text-end">Valor Padrão</th>
                                            <th style="width: 200px;" class="text-end">Valor no Contrato</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($servicos as $servico): 
                                            $servicoSelecionado = false;
                                            $valorPersonalizado = $servico['valor'];
                                            
                                            // Verifica se o serviço está associado ao contrato
                                            if (isset($servicosContrato)) {
                                                foreach ($servicosContrato as $sc) {
                                                    if ($sc['id'] == $servico['id']) {
                                                        $servicoSelecionado = true;
                                                        $valorPersonalizado = $sc['valor_personalizado'] ?? $servico['valor'];
                                                        break;
                                                    }
                                                }
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <input class="form-check-input servico-checkbox" 
                                                           type="checkbox" 
                                                           name="servicos[]" 
                                                           value="<?php echo $servico['id']; ?>"
                                                           <?php echo $servicoSelecionado ? 'checked' : ''; ?>>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($servico['nome']); ?>
                                                </td>
                                                <td class="text-end">
                                                    R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?>
                                                    <input type="hidden" 
                                                           class="valor-padrao"
                                                           value="<?php echo number_format($servico['valor'], 2, ',', '.'); ?>">
                                                </td>
                                                <td>
                                                    <input type="text" 
                                                           class="form-control valor-servico text-end" 
                                                           name="valor_personalizado[<?php echo $servico['id']; ?>]"
                                                           value="<?php echo number_format($valorPersonalizado, 2, ',', '.'); ?>"
                                                           <?php echo $servicoSelecionado ? '' : 'disabled'; ?>>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Valor Total:</strong></td>
                                            <td class="text-end"><strong id="valor_total">R$ 0,00</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="clausulas" class="form-label">Cláusulas</label>
                            <textarea class="form-control" 
                                      id="clausulas" 
                                      name="clausulas" 
                                      rows="10"><?php echo isset($contrato) ? $contrato['clausulas'] : ''; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="<?php echo BASE_URL; ?>/contratos" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Carrega o TinyMCE da CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Carrega a configuração personalizada do TinyMCE -->
    <script src="<?php echo BASE_URL; ?>/assets/js/tinymce-config.js"></script>

    <style>
    .valor-servico:not([disabled]) {
        background-color: #fff !important;
        cursor: text !important;
    }
    .valor-servico[disabled] {
        background-color: #f8f9fa !important;
        cursor: not-allowed !important;
    }
    </style>

    <!-- Script para calcular o valor total -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para formatar o valor em reais (R$)
        function formatarMoeda(valor) {
            // Garante que é um número e formata com 2 casas decimais
            valor = (typeof valor === 'string' ? parseFloat(valor) : valor).toFixed(2);
            // Substitui ponto por vírgula e adiciona pontos nos milhares
            return valor.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Função para converter um valor formatado em número
        function converterParaNumero(valor) {
            if (typeof valor !== 'string') return valor;
            // Remove pontos e substitui vírgula por ponto
            return parseFloat(valor.replace(/\./g, '').replace(',', '.')) || 0;
        }

        // Função para atualizar o valor total dos serviços selecionados
        function atualizarValorTotal() {
            let total = 0;
            // Soma os valores de todos os serviços marcados
            document.querySelectorAll('.servico-checkbox:checked').forEach(function(checkbox) {
                const row = checkbox.closest('tr');
                const inputValor = row.querySelector('.valor-servico');
                const valor = converterParaNumero(inputValor.value);
                console.log('Valor convertido:', valor); // Debug
                total += valor;
            });
            console.log('Total:', total); // Debug
            document.getElementById('valor_total').textContent = 'R$ ' + formatarMoeda(total);
        }

        // Função para habilitar/desabilitar campo de valor do serviço
        function toggleValorPersonalizado(checkbox) {
            const row = checkbox.closest('tr');
            const inputValor = row.querySelector('.valor-servico');
            const valorPadrao = row.querySelector('.valor-padrao').value;
            
            if (checkbox.checked) {
                // Se marcou o checkbox, habilita o campo e coloca foco nele
                inputValor.removeAttribute('disabled');
                inputValor.style.backgroundColor = '#fff';
                inputValor.focus();
            } else {
                // Se desmarcou, desabilita o campo e restaura o valor padrão
                inputValor.setAttribute('disabled', 'disabled');
                inputValor.style.backgroundColor = '#f8f9fa';
                inputValor.value = valorPadrao;
            }
            
            atualizarValorTotal();
        }

        // Adiciona evento de change em todos os checkboxes
        document.querySelectorAll('.servico-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                toggleValorPersonalizado(this);
            });
        });

        // Adiciona eventos em todos os campos de valor
        document.querySelectorAll('.valor-servico').forEach(function(input) {
            // Ao digitar no campo
            input.addEventListener('input', function(e) {
                let valor = e.target.value.replace(/\D/g, '');
                if (valor === '') valor = '0';
                // Converte para número e formata
                valor = (parseFloat(valor) / 100).toFixed(2);
                this.value = valor.replace('.', ',');
                atualizarValorTotal();
            });

            // Ao sair do campo
            input.addEventListener('blur', function() {
                const valor = converterParaNumero(this.value);
                this.value = formatarMoeda(valor);
                atualizarValorTotal();
            });

            // Ao entrar no campo
            input.addEventListener('focus', function() {
                this.select();
            });
        });

        // Calcula o valor total inicial
        atualizarValorTotal();
    });
    </script>
