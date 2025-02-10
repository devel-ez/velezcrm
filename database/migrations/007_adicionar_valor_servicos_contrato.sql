-- Adiciona coluna de valor personalizado na tabela de relacionamento
ALTER TABLE contratos_servicos
ADD COLUMN valor_personalizado DECIMAL(10,2) DEFAULT NULL;
