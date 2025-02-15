-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/02/2025 às 18:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `velezcrm`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `empresa` varchar(100) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `login_hospedagem` varchar(100) DEFAULT NULL,
  `senha_hospedagem` varchar(100) DEFAULT NULL,
  `login_wp` varchar(100) DEFAULT NULL,
  `senha_wp` varchar(100) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `status` enum('ativo','pendente','inativo') NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `empresa`, `cnpj`, `login_hospedagem`, `senha_hospedagem`, `login_wp`, `senha_wp`, `observacoes`, `endereco`, `cidade`, `estado`, `cep`, `data_cadastro`, `status`) VALUES
(14, 'arthur', '', '12312312312', 'asdfdasf', '21342342342342', 'safdas', '234swrf', 'sdf234', 'df2342', 'sadfqweqw', NULL, NULL, NULL, NULL, '2025-02-15 14:25:26', 'ativo'),
(15, 'Felipe', '', '12122222222', 'uioobiub', '98888889999999', 'b9', NULL, 'b9', 'b9b8', '9', NULL, NULL, NULL, NULL, '2025-02-15 14:39:06', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `numero_contrato` varchar(20) DEFAULT NULL,
  `ano_contrato` int(11) GENERATED ALWAYS AS (year(`created_at`)) STORED,
  `titulo` varchar(255) NOT NULL,
  `objeto` text DEFAULT NULL,
  `clausulas` text DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ativo',
  `data_validade` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos`
--

INSERT INTO `contratos` (`id`, `numero_contrato`, `titulo`, `objeto`, `clausulas`, `cliente_id`, `status`, `data_validade`, `created_at`, `updated_at`) VALUES
(29, '29/2025', '43141234', '123123', '123123', 15, 'ativo', '2025-03-17', '2025-02-15 17:40:42', '2025-02-15 17:40:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos_servicos`
--

CREATE TABLE `contratos_servicos` (
  `contrato_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL,
  `valor_personalizado` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contratos_servicos`
--

INSERT INTO `contratos_servicos` (`contrato_id`, `servico_id`, `valor_personalizado`) VALUES
(29, 4, 1500.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `kanban_cards`
--

CREATE TABLE `kanban_cards` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('backlog','todo','doing','done') DEFAULT 'backlog',
  `posicao` int(11) DEFAULT 0,
  `data_criacao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `kanban_cards`
--

INSERT INTO `kanban_cards` (`id`, `cliente_id`, `titulo`, `descricao`, `status`, `posicao`, `data_criacao`) VALUES
(10, 14, 'asdf', 'asdfsadf', 'backlog', 0, '2025-02-15 14:25:36'),
(11, 15, '1', '1', 'backlog', 0, '2025-02-15 14:39:14'),
(12, 15, '2', '2', 'todo', 0, '2025-02-15 14:39:17'),
(13, 15, '3', '3', 'doing', 0, '2025-02-15 14:39:21'),
(14, 15, '4', '4', 'done', 0, '2025-02-15 14:39:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(11) NOT NULL,
  `contrato_id` int(11) DEFAULT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` enum('backlog','todo','doing','done') DEFAULT 'backlog',
  `prioridade` enum('baixa','media','alta') DEFAULT 'media',
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `descricao`, `valor`, `status`) VALUES
(4, 'desenv', 'ADSFASFD', 1500.00, 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','usuario') DEFAULT 'usuario',
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `data_cadastro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `tipo`, `status`, `data_cadastro`) VALUES
(1, 'Admin Teste', 'admin@teste.com', '$2y$10$7ef1bIYbbL7kyv3MQebzPOna5nGtkxkjfNHzo.91feUtm0BcWmNFW', 'admin', 'ativo', '2025-02-14 18:13:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_nome_telefone` (`nome`,`telefone`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contratos_ibfk_1` (`cliente_id`);

--
-- Índices de tabela `contratos_servicos`
--
ALTER TABLE `contratos_servicos`
  ADD PRIMARY KEY (`contrato_id`,`servico_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `kanban_cards`
--
ALTER TABLE `kanban_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrato_id` (`contrato_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `kanban_cards`
--
ALTER TABLE `kanban_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `contratos`
--
ALTER TABLE `contratos`
  ADD CONSTRAINT `contratos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `contratos_servicos`
--
ALTER TABLE `contratos_servicos`
  ADD CONSTRAINT `contratos_servicos_ibfk_1` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contratos_servicos_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `kanban_cards`
--
ALTER TABLE `kanban_cards`
  ADD CONSTRAINT `kanban_cards_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `projetos_ibfk_1` FOREIGN KEY (`contrato_id`) REFERENCES `contratos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
