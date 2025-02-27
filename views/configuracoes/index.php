<?php if (isset($flash)): ?>
    <div class="alert alert-<?= $flash['tipo'] ?> alert-dismissible fade show" role="alert">
        <?= $flash['mensagem'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary"><i class="fas fa-users-cog"></i> Gerenciamento de Usuários</h2>
        <a href="#" class="btn btn-success" onclick="abrirModalUsuario()"><i class="fas fa-user-plus"></i> Adicionar Novo</a>
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
                                    <!-- Botão Editar -->
                                    <button class="btn btn-warning btn-sm" onclick="abrirModalUsuario(<?= $usuario['id'] ?>, '<?= $usuario['nome'] ?>', '<?= $usuario['email'] ?>', '<?= $usuario['tipo'] ?>')">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>


                                    <!-- Botão Excluir (Confirmação antes de enviar a requisição) -->
                                    <button class="btn btn-danger btn-sm" onclick="confirmarExclusao(<?= $usuario['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i> Excluir
                                    </button>

                                    <!-- Botão Alterar Senha -->
                                    <button class="btn btn-primary btn-sm" onclick="abrirModalSenha(<?= $usuario['id'] ?>)">
                                        <i class="fas fa-key"></i> Alterar Senha
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

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="modalExcluir" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir este usuário?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formExcluir" method="POST" action="/velezcrm/configuracoes/excluir">
                    <input type="hidden" name="id" id="userIdExcluir">
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Alterar Senha -->
<div class="modal fade" id="modalSenha" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-key"></i> Alterar Senha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/velezcrm/configuracoes/mudarSenha">
                    <input type="hidden" name="id" id="userIdSenha">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" name="nova_senha" id="nova_senha" class="form-control" required>
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Adicionar/Editar Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tituloModalUsuario"><i class="fas fa-user"></i> Adicionar Usuário</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formUsuario" method="POST" action="/configuracoes/salvar">
                    <input type="hidden" name="id" id="usuarioId">

                    <label>Nome:</label>
                    <input type="text" name="nome" id="usuarioNome" class="form-control" required>

                    <label>Email:</label>
                    <input type="email" name="email" id="usuarioEmail" class="form-control" required>

                    <!-- Campo Senha será exibido apenas para Novo Usuário -->
                    <div id="campoSenha">
                        <label>Senha:</label>
                        <input type="password" name="senha" id="usuarioSenha" class="form-control">
                    </div>

                    <label>Tipo:</label>
                    <select name="tipo" id="usuarioTipo" class="form-control">
                        <option value="usuario">Usuário</option>
                        <option value="admin">Admin</option>
                    </select>

                    <button type="submit" class="btn btn-success mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Scripts para os botões -->
<script>
    function confirmarExclusao(userId) {
        document.getElementById('userIdExcluir').value = userId;
        var modal = new bootstrap.Modal(document.getElementById('modalExcluir'));
        modal.show();
    }

    function abrirModalSenha(userId) {
        document.getElementById('userIdSenha').value = userId;
        var modal = new bootstrap.Modal(document.getElementById('modalSenha'));
        modal.show();
    }

    function abrirModalUsuario(id = '', nome = '', email = '', tipo = '') {
        document.getElementById('usuarioId').value = id;
        document.getElementById('usuarioNome').value = nome;
        document.getElementById('usuarioEmail').value = email;
        document.getElementById('usuarioTipo').value = tipo || 'usuario';

        if (id) {
            // Se estiver editando, esconde o campo de senha
            document.getElementById('tituloModalUsuario').innerText = "Editar Usuário";
            document.getElementById('formUsuario').action = "/velezcrm/configuracoes/salvar";
            document.getElementById('campoSenha').style.display = "none";
        } else {
            // Se for um novo usuário, exibe o campo de senha
            document.getElementById('tituloModalUsuario').innerText = "Adicionar Usuário";
            document.getElementById('formUsuario').action = "/velezcrm/configuracoes/salvar";
            document.getElementById('campoSenha').style.display = "block";
        }

        var modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
        modal.show();
    }
</script>