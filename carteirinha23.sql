-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 17/02/2025 às 13:23
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
-- Banco de dados: `carteirinha23`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) NOT NULL,
  `principal` varchar(255) NOT NULL,
  `acompanhamento` varchar(255) NOT NULL,
  `sobremesa` varchar(255) NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
(47, '2024-10-21', 'segunda', 'Carne cozida', 'Arroz e feijão', 'Maçã', 0),
(48, '2024-10-22', 'terca', 'Calabresa assada', 'Alface', 'Laranja', 0),
(49, '2024-10-23', 'quarta', 'Farofa de ovo', 'Salada', 'Banana', 0),
(50, '2024-10-24', 'quinta', 'Feijoada', 'Farofa', 'a', 0),
(51, '2024-10-25', 'sexta', 'Macarrão', 'Batata palha', 'Abacaxi', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `horario_padrao`
--

CREATE TABLE `horario_padrao` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `inicio_vig` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `horario_padrao`
--

INSERT INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(1, '2024-07-17 07:10:38', '2024-07-18 07:11:14', '16:10:00'),
(2, '2024-07-18 07:11:14', '2024-07-19 07:14:12', '22:11:00'),
(3, '2024-07-19 07:14:12', '2024-07-19 07:14:33', '04:14:00'),
(4, '2024-07-19 07:14:33', '2024-07-26 12:19:36', '09:00:00'),
(5, '2024-07-26 12:19:36', '2024-09-16 19:26:52', '10:19:00'),
(6, '2024-09-16 19:26:52', NULL, '21:26:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `justificativa`
--

INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio'),
(4, 'Outro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_remetente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `assunto` text NOT NULL,
  `mensagem` text NOT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT 0,
  `transferencia` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `notificacao`
--

INSERT INTO `notificacao` (`id`, `id_remetente`, `id_destinatario`, `data`, `hora`, `assunto`, `mensagem`, `lida`, `transferencia`) VALUES
(8, 3, 2, '2025-02-04', '16:09:28', 'Transferência de Almoço', 'Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais', 1, 2),
(11, 1, 2, '2025-02-04', '17:45:02', 'Testando notificação', 'Teste notificação', 1, 0),
(15, 2, 3, '2025-02-04', '20:22:21', 'Transferência de Almoço', 'Saudações Botteste, o estudante Vitor fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais', 1, 2),
(16, 3, 2, '2025-02-04', '20:40:38', 'Transferência de Almoço', 'Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: Passei mal e tive que ir embora', 1, 2),
(17, 1, 2, '2025-02-05', '06:23:10', 'Testando novas notificações', 'lorem ipsum.', 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `refeicao`
--

CREATE TABLE `refeicao` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  `id_status_ref` int(11) NOT NULL,
  `id_justificativa` int(11) DEFAULT NULL,
  `data_solicitacao` date NOT NULL,
  `hora_solicitacao` time NOT NULL,
  `outra_justificativa` varchar(100) DEFAULT NULL,
  `motivo_cancelamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `refeicao`
--

INSERT INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `hora_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
(18, 2, 47, 1, 3, '2025-02-03', '16:40:39', 'projeto', 'nao quero mais'),
(19, 2, 47, 1, 2, '2025-02-03', '17:18:25', 'transporte', NULL),
(20, 2, 48, 1, 1, '2025-02-04', '15:45:15', 'contra-turno', NULL),
(21, 2, 47, 1, 2, '2025-02-10', '14:43:37', 'transporte', 'nao quero mais'),
(22, 2, 47, 1, 2, '2025-02-10', '15:14:33', 'transporte', 'nao quero mais'),
(23, 2, 47, 1, 3, '2025-02-10', '15:15:52', 'projeto', ''),
(24, 2, 47, 1, 1, '2025-02-10', '15:16:38', 'contra-turno', 'nao quero mais'),
(25, 2, 47, 1, 2, '2025-02-10', '15:29:06', 'transporte', 'Passei mal e tive que ir embora'),
(26, 2, 47, 1, 2, '2025-02-10', '15:31:21', 'transporte', 'Passei mal e tive que ir embora'),
(27, 2, 47, 1, 3, '2025-02-10', '15:32:09', 'projeto', ''),
(28, 2, 47, 1, 2, '2025-02-10', '16:32:57', 'transporte', 'Passei mal e tive que ir embora'),
(29, 2, 49, 1, 1, '2025-02-12', '19:16:48', 'contra-turno', NULL);

--
-- Acionadores `refeicao`
--
DELIMITER $$
CREATE TRIGGER `trg01_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.id_status_ref = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg02_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.data_solicitacao = CONVERT_TZ(NOW(),'+00:00', '+00:00')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_msg`
--

CREATE TABLE `status_msg` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `status_msg`
--

INSERT INTO `status_msg` (`id`, `descricao`) VALUES
(1, 'Lida'),
(2, 'Não Lida');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_notification`
--

CREATE TABLE `status_notification` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `status_feedback` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `status_notification`
--

INSERT INTO `status_notification` (`id`, `descricao`) VALUES
(0, 'Sem transferência'),
(1, 'Em processo\r\n'),
(2, 'Transferida'),
(3, 'Cancelada'),
(5, 'Cancelada por tempo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_ref`
--

CREATE TABLE `status_ref` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `status_ref`
--

INSERT INTO `status_ref` (`id`, `descricao`) VALUES
(1, 'Agendada'),
(2, 'Cancelada'),
(3, 'Confirmada'),
(4, 'Não compareceu');

INSERT INTO `status_feedback` (`id`, `descricao`) VALUES
(1, 'Muito Ruim'),
(2, 'Ruim'),
(3, 'Neutro'),
(4, 'Bom'),
(5, 'Muito bom');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `matricula` varchar(255) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `telefone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;


CREATE TABLE `feedback` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `nota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `matricula`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '20201180041', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
(2, 'vitor', 'vitor@gmail.com', '20201180046', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00'),
(3, 'botteste', 'botteste@gmail.com', '20201180011', '202cb962ac59075b964b07152d234b70', 'estudante', '75982777354');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD KEY `fk_remetente` (`id_remetente`),
  ADD KEY `fk_destinatario` (`id_destinatario`),
  ADD KEY `fk_transferencia_notification` (`transferencia`);

--
-- Índices de tabela `refeicao`
--
ALTER TABLE `refeicao`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cardapio` (`id_cardapio`),
  ADD KEY `id_status` (`id_status_ref`),
  ADD KEY `id_justificativa` (`id_justificativa`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD UNIQUE KEY `email` (`email`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `fk_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_remetente` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transferencia_notification` FOREIGN KEY (`transferencia`) REFERENCES `status_notification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `refeicao`
--
ALTER TABLE `refeicao`
  ADD CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`id_status_ref`) REFERENCES `status_ref` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_4` FOREIGN KEY (`id_justificativa`) REFERENCES `justificativa` (`id`);
COMMIT;

ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nota` FOREIGN KEY (`nota`) REFERENCES `status_feedback` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
