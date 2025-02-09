-- Adicionando índice único para nome e telefone
ALTER TABLE clientes
ADD CONSTRAINT uk_nome_telefone UNIQUE (nome, telefone);
