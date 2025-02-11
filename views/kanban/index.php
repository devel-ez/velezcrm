<?php
// O conteúdo será inserido automaticamente no layout principal pelo Controller
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kanban Board</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php if (isset($flash)): ?>
                <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $flash['mensagem']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Seleção de Cliente e Criação do Kanban -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="cliente-select" class="form-label">Selecione um Cliente</label>
                                <select id="cliente-select" class="form-select">
                                    <option value="">Escolha um cliente...</option>
                                    <?php foreach($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nome']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">&nbsp;</label>
                            <div>
                                <button id="criar-kanban" class="btn btn-primary w-100" style="display: none;">
                                    <i class="fas fa-plus-circle me-2"></i>Criar Kanban
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quadro Kanban -->
            <div id="kanban-board" style="display: none;">
                <div class="row">
                    <!-- Coluna Backlog -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-secondary">
                                <h3 class="card-title">Backlog</h3>
                                <button class="btn btn-tool float-end add-card" data-status="backlog">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body connectedSortable" id="backlog">
                                <div class="empty-column-message">
                                    Nenhum card nesta coluna
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna À Fazer -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3 class="card-title">À Fazer</h3>
                                <button class="btn btn-tool float-end add-card" data-status="todo">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body connectedSortable" id="todo">
                                <div class="empty-column-message">
                                    Nenhum card nesta coluna
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Em Andamento -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Em Andamento</h3>
                                <button class="btn btn-tool float-end add-card" data-status="doing">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body connectedSortable" id="doing">
                                <div class="empty-column-message">
                                    Nenhum card nesta coluna
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Concluído -->
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header bg-success">
                                <h3 class="card-title">Concluído</h3>
                                <button class="btn btn-tool float-end add-card" data-status="done">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body connectedSortable" id="done">
                                <div class="empty-column-message">
                                    Nenhum card nesta coluna
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para adicionar card -->
<div class="modal fade" id="cardModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Novo Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <input type="hidden" id="card-status">
                    <div class="form-group mb-3">
                        <label for="card-titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="card-titulo" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="card-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="card-descricao" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveCard">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts específicos para o Kanban -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado, verificando jQuery...');
    
    // Verifica se o jQuery está disponível
    if (typeof jQuery === 'undefined') {
        console.error('jQuery não está carregado!');
        return;
    }
    
    // Usa jQuery com alias $ para evitar conflitos
    jQuery(function($) {
        console.log('jQuery pronto, iniciando Kanban...');
        
        // Quando selecionar um cliente
        $('#cliente-select').on('change', function() {
            console.log('Cliente selecionado');
            const clienteId = $(this).val();
            
            if (clienteId) {
                console.log('Mostrando botão criar kanban');
                $('#criar-kanban').show();
            } else {
                console.log('Escondendo botão e quadro');
                $('#criar-kanban').hide();
                $('#kanban-board').hide();
            }
        });

        // Quando clicar no botão criar kanban
        $('#criar-kanban').on('click', function() {
            console.log('Botão criar kanban clicado');
            const clienteId = $('#cliente-select').val();
            
            if (clienteId) {
                console.log('Carregando cards do cliente:', clienteId);
                $('#kanban-board').show();
                loadKanbanCards(clienteId);
            }
        });

        // Adicionar novo card
        $('.add-card').on('click', function() {
            const status = $(this).data('status');
            $('#card-status').val(status);
            $('#cardModal').modal('show');
        });

        // Salvar card
        $('#saveCard').on('click', function() {
            const clienteId = $('#cliente-select').val();
            const titulo = $('#card-titulo').val();
            const descricao = $('#card-descricao').val();
            const status = $('#card-status').val();

            if (!titulo) {
                alert('Por favor, preencha o título do card');
                return;
            }

            $.ajax({
                url: BASE_URL + '/kanban/createCard',
                method: 'POST',
                data: {
                    cliente_id: clienteId,
                    titulo: titulo,
                    descricao: descricao,
                    status: status
                },
                success: function(response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.success) {
                            $('#cardModal').modal('hide');
                            loadKanbanCards(clienteId);
                            $('#cardForm')[0].reset();
                        } else {
                            alert('Erro: ' + (data.error || 'Erro desconhecido'));
                        }
                    } catch (e) {
                        console.error('Erro ao processar resposta:', e);
                        alert('Erro ao processar resposta do servidor');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao comunicar com o servidor');
                }
            });
        });

        // Função para carregar os cards do Kanban
        function loadKanbanCards(clienteId) {
            $.ajax({
                url: BASE_URL + `/kanban/getCards/${clienteId}`,
                method: 'GET',
                success: function(response) {
                    try {
                        const cards = JSON.parse(response);
                        if (cards.error) {
                            alert('Erro: ' + cards.error);
                            return;
                        }
                        
                        // Limpa todas as colunas
                        $('.connectedSortable').empty();
                        
                        // Adiciona a mensagem de coluna vazia
                        $('.connectedSortable').append('<div class="empty-column-message">Nenhum card nesta coluna</div>');
                        
                        // Distribui os cards nas colunas corretas
                        cards.forEach(card => {
                            const cardHtml = createCardHtml(card);
                            const column = $(`#${card.status}`);
                            column.find('.empty-column-message').remove();
                            column.append(cardHtml);
                        });

                        // Inicializa o sortable após carregar os cards
                        initializeSortable();
                    } catch (e) {
                        console.error('Erro ao processar cards:', e);
                        alert('Erro ao processar resposta do servidor');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar cards:', error);
                    alert('Erro ao carregar os cards');
                }
            });
        }

        // Função para inicializar o sortable
        function initializeSortable() {
            $(".connectedSortable").sortable({
                connectWith: ".connectedSortable",
                placeholder: "sort-highlight",
                forcePlaceholderSize: true,
                handle: ".card-header",
                update: function(event, ui) {
                    if (this === ui.item.parent()[0]) {
                        const cardId = ui.item.attr('data-id');
                        const newStatus = $(this).attr('id');
                        const position = ui.item.index();
                        
                        updateCardStatus(cardId, newStatus, position);
                    }
                }
            }).disableSelection();
        }

        // Função para criar o HTML do card
        function createCardHtml(card) {
            const date = new Date(card.data_criacao);
            const formattedDate = date.toLocaleDateString('pt-BR');
            
            return `
                <div class="card card-info" data-id="${card.id}">
                    <div class="card-header">
                        <h5 class="card-title">${escapeHtml(card.titulo)}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">${escapeHtml(card.descricao || '')}</p>
                        <small class="text-muted">Criado em: ${formattedDate}</small>
                    </div>
                </div>
            `;
        }

        // Função para atualizar o status do card
        function updateCardStatus(cardId, status, position) {
            $.ajax({
                url: BASE_URL + '/kanban/updateCardStatus',
                method: 'POST',
                data: {
                    card_id: cardId,
                    status: status,
                    posicao: position
                },
                success: function(response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.error) {
                            alert('Erro: ' + data.error);
                            loadKanbanCards($('#cliente-select').val());
                        }
                    } catch (e) {
                        console.error('Erro ao processar resposta:', e);
                        alert('Erro ao processar resposta do servidor');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao atualizar card:', error);
                    alert('Erro ao atualizar o card');
                    loadKanbanCards($('#cliente-select').val());
                }
            });
        }

        // Função para escapar HTML e prevenir XSS
        function escapeHtml(unsafe) {
            return unsafe
                ? unsafe
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;")
                : '';
        }

        // Log inicial
        console.log('Kanban inicializado com sucesso!');
    });
});
</script>

<style>
/* Estilos do Kanban */
.card {
    margin-bottom: 20px;
}
.card-header {
    padding: 0.75rem 1.25rem;
    cursor: move;
}
.card-header .card-title {
    margin: 0;
    font-size: 1rem;
}
.btn-tool {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    color: rgba(255,255,255,0.8);
    background: transparent;
    border: none;
}
.btn-tool:hover {
    color: #fff;
}
.connectedSortable {
    min-height: 200px;
    padding: 15px;
}
.sort-highlight {
    background: #f4f4f4;
    border: 2px dashed #ccc;
    margin-bottom: 10px;
}
.empty-column-message {
    text-align: center;
    padding: 20px;
    color: #6c757d;
    font-style: italic;
}
</style>
