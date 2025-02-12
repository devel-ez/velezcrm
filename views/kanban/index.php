<?php
// O conteúdo será inserido automaticamente no layout principal pelo Controller
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kanban de Projetos</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="">
        <div class="container-fluid">
            <!-- Card de Seleção de Cliente -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-circle me-2"></i>
                        Selecione o Cliente
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 position-relative">
                            <div class="form-group mb-0">
                                <select class="form-control form-control-lg" id="cliente-select">
                                    <option value="">Escolha um cliente para visualizar seu quadro Kanban...</option>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <option value="<?php echo $cliente['id']; ?>">
                                            <?php echo htmlspecialchars($cliente['nome']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Seta animada -->
                            <div class="select-arrow" id="select-arrow">
                                <i class="fas fa-arrow-down"></i>
                                <span></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="cliente-info" class="text-muted" style="display: none;">
                                <i class="fas fa-info-circle me-1"></i>
                                <span>Visualizando quadro Kanban do cliente: </span>
                                <strong id="cliente-nome-display"></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanban Board -->
            <div id="kanban-board" style="display: none;">
                <div class="row g-2">
                    <!-- Coluna Backlog -->
                    <div class="col-md-3 px-1">
                        <div class="card h-100">
                            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center py-2">
                                <h5 class="card-title mb-0">Backlog</h5>
                                <button class="btn btn-sm btn-light add-card" data-status="backlog">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <div id="backlog" class="connectedSortable min-height-100">
                                    <div class="empty-column-message">Nenhum card nesta coluna</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna À Fazer -->
                    <div class="col-md-3 px-1">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                                <h5 class="card-title mb-0">À Fazer</h5>
                                <button class="btn btn-sm btn-light add-card" data-status="todo">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <div id="todo" class="connectedSortable min-height-100">
                                    <div class="empty-column-message">Nenhum card nesta coluna</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Em Andamento -->
                    <div class="col-md-3 px-1">
                        <div class="card h-100">
                            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center py-2">
                                <h5 class="card-title mb-0">Em Andamento</h5>
                                <button class="btn btn-sm btn-light add-card" data-status="doing">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <div id="doing" class="connectedSortable min-height-100">
                                    <div class="empty-column-message">Nenhum card nesta coluna</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna Concluído -->
                    <div class="col-md-3 px-1">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-2">
                                <h5 class="card-title mb-0">Concluído</h5>
                                <button class="btn btn-sm btn-light add-card" data-status="done">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body p-2">
                                <div id="done" class="connectedSortable min-height-100">
                                    <div class="empty-column-message">Nenhum card nesta coluna</div>
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
<div class="modal fade" id="cardModal" tabindex="-1" aria-labelledby="cardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardModalLabel">Novo Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="cardForm">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status">
                            <option value="backlog">Backlog</option>
                            <option value="doing">Em Andamento</option>
                            <option value="done">Concluído</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveCard()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editCardModal" tabindex="-1" aria-labelledby="editCardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCardModalLabel">Editar Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <form id="editCardForm">
                    <input type="hidden" id="edit-card-id">
                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit-titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="edit-descricao" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="saveCardEdit()">Salvar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts específicos para o Kanban -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
    // Função para carregar scripts dinamicamente
    function loadScript(url, callback) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = url;
        script.onload = callback;
        document.head.appendChild(script);
    }

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

            // Função para verificar e carregar jQuery UI se necessário
            function ensureJQueryUI() {
                if (typeof $.ui === 'undefined' || !$.fn.sortable) {
                    console.log('Carregando jQuery UI...');
                    loadScript('https://code.jquery.com/ui/1.13.2/jquery-ui.min.js', function() {
                        console.log('Verificando Sortable:', $.fn.sortable ? 'Disponível' : 'Não disponível');
                    });
                } else {
                    console.log('Verificando Sortable:', $.fn.sortable ? 'Disponível' : 'Não disponível');
                }
            }

            // Chama a função para garantir jQuery UI
            ensureJQueryUI();

            // Quando selecionar um cliente
            $('#cliente-select').on('change', function() {
                const clienteId = $(this).val();
                const clienteNome = $(this).find('option:selected').text();
                console.log('Cliente selecionado:', clienteId, clienteNome);

                if (clienteId) {
                    // Esconder a seta quando um cliente for selecionado
                    $('#select-arrow').fadeOut();
                    
                    // Mostrar informações do cliente
                    $('#cliente-nome-display').text(clienteNome);
                    $('#cliente-info').show();
                    
                    // Carregar e mostrar o quadro Kanban
                    $('#kanban-board').show();
                    loadKanbanCards(clienteId);
                } else {
                    // Mostrar a seta novamente
                    $('#select-arrow').fadeIn();
                    
                    // Esconder informações e quadro
                    $('#cliente-info').hide();
                    $('#kanban-board').hide();
                }
            });

            // Animar a seta quando o select receber foco
            $('#cliente-select').on('focus', function() {
                $('#select-arrow').addClass('active');
            }).on('blur', function() {
                $('#select-arrow').removeClass('active');
            });

            // Adicionar novo card
            $('.add-card').on('click', function() {
                const status = $(this).data('status');
                openNewCardModal(status);
            });

            // Função para abrir modal de novo card
            window.openNewCardModal = function(status) {
                $('#status').val(status);
                const cardModal = new bootstrap.Modal(document.getElementById('cardModal'));
                cardModal.show();
            };

            // Salvar card
            window.saveCard = function() {
                const titulo = $('#titulo').val();
                const descricao = $('#descricao').val();
                const status = $('#status').val();
                const clienteId = $('#cliente-select').val();

                if (!titulo) {
                    alert('O título é obrigatório');
                    return;
                }

                if (!clienteId) {
                    alert('Selecione um cliente');
                    return;
                }

                const data = {
                    cliente_id: clienteId,
                    titulo: titulo,
                    descricao: descricao,
                    status: status,
                    data_criacao: new Date().toISOString().slice(0, 19).replace('T', ' ')
                };

                $.ajax({
                    url: BASE_URL + '/kanban/createCard',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            // Bootstrap 5: Esconder modal
                            const cardModal = bootstrap.Modal.getInstance(document.getElementById('cardModal'));
                            cardModal.hide();
                            
                            // Limpar formulário
                            $('#titulo').val('');
                            $('#descricao').val('');
                            
                            // Recarregar cards
                            loadKanbanCards(clienteId);
                        } else {
                            alert('Erro ao criar o card');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao criar card:', error);
                        alert('Erro ao criar o card');
                    }
                });
            };

            // Função para carregar os cards do Kanban
            function loadKanbanCards(clienteId) {
                $.ajax({
                    url: BASE_URL + `/kanban/getCards/${clienteId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(cards) {
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
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao carregar cards:', error);
                        const errorMessage = xhr.responseJSON ?
                            xhr.responseJSON.error :
                            'Erro ao carregar os cards';
                        alert(errorMessage);
                    }
                });
            }

            // Função para criar HTML do card
            function createCardHtml(card) {
                const titulo = card.titulo.replace(/'/g, "\\'");
                const descricao = (card.descricao || '').replace(/'/g, "\\'");
                
                return `
                <div class="card mb-2" data-id="${card.id}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">${card.titulo}</h5>
                        <div class="card-actions">
                            <button class="btn btn-xs btn-outline-primary edit-card mr-1" onclick="editCard(${card.id}, event)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-xs btn-outline-danger delete-card" onclick="deleteCard(${card.id}, event)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">${card.descricao || 'Sem descrição'}</p>
                    </div>
                </div>`;
            }

            // Função para excluir card
            window.deleteCard = function(cardId, event) {
                // Impede a propagação do evento para não acionar o sortable
                event.stopPropagation();
                
                if (!confirm('Tem certeza que deseja excluir este card?')) {
                    return;
                }

                $.ajax({
                    url: BASE_URL + '/kanban/deleteCard',
                    method: 'POST',
                    data: {
                        card_id: cardId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Recarrega os cards após excluir
                            loadKanbanCards($('#cliente-select').val());
                        } else {
                            alert('Erro ao excluir o card');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao excluir card:', error);
                        alert('Erro ao excluir o card');
                        // Recarrega os cards para restaurar a ordem anterior
                        loadKanbanCards($('#cliente-select').val());
                    }
                });
            };

            // Função para editar card
            window.editCard = function(cardId, event) {
                event.stopPropagation();
                
                $.ajax({
                    url: BASE_URL + `/kanban/getCard/${cardId}`,
                    method: 'GET',
                    success: function(card) {
                        if (card.error) {
                            alert('Erro ao carregar o card: ' + card.error);
                            return;
                        }

                        $('#edit-card-id').val(card.id);
                        $('#edit-titulo').val(card.titulo);
                        $('#edit-descricao').val(card.descricao);
                        
                        // Bootstrap 5: Mostrar modal
                        const editModal = new bootstrap.Modal(document.getElementById('editCardModal'));
                        editModal.show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao carregar card:', error);
                        alert('Erro ao carregar o card');
                    }
                });
            };

            // Função para salvar edição do card
            window.saveCardEdit = function() {
                const cardId = $('#edit-card-id').val();
                const titulo = $('#edit-titulo').val();
                const descricao = $('#edit-descricao').val();

                if (!titulo) {
                    alert('O título é obrigatório');
                    return;
                }

                $.ajax({
                    url: BASE_URL + '/kanban/editCard',
                    method: 'POST',
                    data: {
                        card_id: cardId,
                        titulo: titulo,
                        descricao: descricao
                    },
                    success: function(response) {
                        if (response.success) {
                            // Bootstrap 5: Esconder modal
                            const editModal = bootstrap.Modal.getInstance(document.getElementById('editCardModal'));
                            editModal.hide();
                            
                            loadKanbanCards($('#cliente-select').val());
                        } else {
                            alert('Erro ao editar o card');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao editar card:', error);
                        alert('Erro ao editar o card');
                    }
                });
            };

            // Função para inicializar o sortable
            function initializeSortable() {
                // Verifica se o Sortable está disponível
                if (!$.fn.sortable) {
                    console.error('Sortable não está disponível!');
                    return;
                }

                $(".connectedSortable").sortable({
                    connectWith: ".connectedSortable",
                    placeholder: "sort-highlight",
                    forcePlaceholderSize: true,
                    handle: ".card-header",
                    update: function(event, ui) {
                        if (this === ui.item.parent()[0]) {
                            const cardId = ui.item.attr('data-id');
                            const newStatus = $(this).attr('id');
                            
                            // Calcula a nova posição baseada na ordem atual dos cards
                            const cards = $(this).children('.card');
                            const position = cards.index(ui.item);

                            console.log('Atualizando card:', {
                                cardId: cardId,
                                newStatus: newStatus,
                                position: position
                            });

                            // Enviar atualização de status para o servidor
                            $.ajax({
                                url: BASE_URL + '/kanban/updateCardStatus',
                                method: 'POST',
                                data: {
                                    card_id: cardId,
                                    new_status: newStatus,
                                    position: position
                                },
                                success: function(response) {
                                    console.log('Card atualizado com sucesso');
                                    // Recarrega os cards para garantir a ordem correta
                                    loadKanbanCards($('#cliente-select').val());
                                },
                                error: function(xhr, status, error) {
                                    console.error('Erro ao atualizar card:', error);
                                    alert('Erro ao mover card');
                                    // Recarrega os cards para restaurar a ordem anterior
                                    loadKanbanCards($('#cliente-select').val());
                                }
                            });
                        }
                    }
                }).disableSelection();
            }

            // Adiciona estilo para o botão de exclusão
            const style = document.createElement('style');
            style.textContent = `
                .card-header .delete-card {
                    opacity: 0;
                    transition: opacity 0.2s;
                }
                .card:hover .card-header .delete-card {
                    opacity: 1;
                }
                .card-header {
                    cursor: move;
                }
                .delete-card {
                    cursor: pointer;
                }
                .edit-card {
                    cursor: pointer;
                }
            `;
            document.head.appendChild(style);

            console.log('Kanban inicializado com sucesso!');
        });
    });
</script>

<style>
    /* Estilos gerais */
    .content-wrapper {
        background-color: #f4f6f9;
        padding: 20px;
    }

    /* Estilos do card de seleção */
    .card-outline.card-primary {
        border-top: 3px solid #007bff;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: 0.75rem 1.25rem;
    }

    .card-title {
        margin: 0;
        font-size: 1.1rem;
        color: #1f2d3d;
    }

    .card-title i {
        color: #007bff;
        margin-right: 0.5rem;
    }

    /* Estilos do select */
    .form-control-lg {
        height: calc(2.875rem + 2px);
        padding: 0.5rem 1rem;
        font-size: 1.1rem;
        border-radius: 0.3rem;
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control-lg:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    /* Estilos da informação do cliente */
    #cliente-info {
        padding: 0.5rem 0;
        font-size: 1rem;
    }

    #cliente-info i {
        color: #6c757d;
    }

    #cliente-nome-display {
        color: #007bff;
    }

    /* Estilos do Kanban */
    .content-wrapper {
        background-color: #f4f6f9;
    }

    .card-header {
        cursor: move;
        background-color: #f8f9fa;
    }

    .sort-highlight {
        background: #f4f6f9;
        border: 2px dashed #ced4da;
        margin-bottom: 10px;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .card:hover .card-actions {
        opacity: 1;
    }

    .edit-card, .delete-card {
        cursor: pointer;
    }

    .card-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        transition: box-shadow 0.3s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 0 3px rgba(0,0,0,.125), 0 3px 6px rgba(0,0,0,.2);
    }

    /* Estilo para a seta animada */
    .select-arrow {
        position: absolute;
        top: 50%;
        right: 3rem;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        color: #007bff;
        animation: bounce 2s infinite;
        z-index: 1;
    }

    .select-arrow i {
        margin-right: 0.5rem;
        font-size: 1.2rem;
    }

    .select-arrow span {
        font-size: 0.9rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .select-arrow.active {
        animation: none;
        transform: translateY(-50%) scale(1.1);
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(-50%);
        }
        40% {
            transform: translateY(-70%);
        }
        60% {
            transform: translateY(-60%);
        }
    }

    /* Ajuste no select para não sobrepor a seta */
    .form-control-lg {
        padding-right: 8rem;
    }

    /* Estilos para botões menores */
    .btn-xs {
        padding: 0.1rem 0.25rem;
        font-size: 0.7rem;
        line-height: 1.2;
    }

    .card-actions .btn-xs {
        margin-right: 0.25rem;
    }

    .card-actions .btn-xs i {
        font-size: 0.7rem;
    }

    .card-actions {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>