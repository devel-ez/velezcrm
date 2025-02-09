-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS velezcrm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE velezcrm;

-- Tabela de clientes
CREATE TABLE IF NOT EXISTS clientes (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `login_hospedagem` varchar(100) DEFAULT NULL,
  `senha_hospedagem` varchar(100) DEFAULT NULL,
  `login_wp` varchar(100) DEFAULT NULL,
  `senha_wp` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` enum('ativo','inativo','pendente') NOT NULL DEFAULT 'ativo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabela de serviços
CREATE TABLE IF NOT EXISTS servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo'
);

-- Tabela de contratos
CREATE TABLE IF NOT EXISTS contratos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    servico_id INT,
    data_inicio DATE,
    data_fim DATE,
    valor_total DECIMAL(10,2),
    status ENUM('em_andamento', 'concluido', 'cancelado') DEFAULT 'em_andamento',
    observacoes TEXT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (servico_id) REFERENCES servicos(id)
);

-- Tabela de projetos (Kanban)
CREATE TABLE IF NOT EXISTS projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contrato_id INT,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    status ENUM('backlog', 'todo', 'doing', 'done') DEFAULT 'backlog',
    prioridade ENUM('baixa', 'media', 'alta') DEFAULT 'media',
    data_inicio DATE,
    data_fim DATE,
    FOREIGN KEY (contrato_id) REFERENCES contratos(id)
);

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'usuario') DEFAULT 'usuario',
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);
