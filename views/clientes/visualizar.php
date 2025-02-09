<div class="row mb-4">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Detalhes do Cliente</h3>
                    <div>
                        <a href="<?php echo BASE_URL; ?>/clientes/editar/<?php echo $cliente['id']; ?>" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="<?php echo BASE_URL; ?>/clientes" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informações Básicas</h5>
                        <table class="table table-striped">
                            <tr>
                                <th width="30%">Nome</th>
                                <td><?php echo $cliente['nome']; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $cliente['email']; ?></td>
                            </tr>
                            <tr>
                                <th>Telefone</th>
                                <td><?php echo $cliente['telefone']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge <?php echo $cliente['status'] === 'ativo' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo ucfirst($cliente['status']); ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Informações da Empresa</h5>
                        <table class="table table-striped">
                            <tr>
                                <th width="30%">Empresa</th>
                                <td><?php echo $cliente['empresa']; ?></td>
                            </tr>
                            <tr>
                                <th>CNPJ</th>
                                <td><?php echo $cliente['cnpj']; ?></td>
                            </tr>
                            <tr>
                                <th>Endereço</th>
                                <td><?php echo $cliente['endereco']; ?></td>
                            </tr>
                            <tr>
                                <th>Cidade/Estado</th>
                                <td><?php echo $cliente['cidade']; ?>/<?php echo $cliente['estado']; ?></td>
                            </tr>
                            <tr>
                                <th>CEP</th>
                                <td><?php echo $cliente['cep']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5>Contratos</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Serviço</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum contrato encontrado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
