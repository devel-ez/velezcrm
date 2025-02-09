-- Modificar o campo status para incluir a opção 'pendente'
ALTER TABLE clientes MODIFY COLUMN status ENUM('ativo', 'pendente', 'inativo') NOT NULL DEFAULT 'ativo';
