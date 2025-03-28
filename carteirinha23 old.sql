-- --------------------------------------------------------
-- Servidor:                     carteirinha23-carteirinha23.j.aivencloud.com
-- Versão do servidor:           8.0.35 - Source distribution
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para carteirinha23
CREATE DATABASE IF NOT EXISTS `carteirinha23`
USE `carteirinha23`;

-- Copiando estrutura para tabela carteirinha23.cardapio
CREATE TABLE IF NOT EXISTS `cardapio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `principal` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `acompanhamento` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `sobremesa` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.cardapio: ~5 rows (aproximadamente)
REPLACE INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
	(47, '2024-10-21', 'segunda', 'Carne cozida', 'Arroz e feijão', 'Maçã', 0),
	(48, '2024-10-22', 'terca', 'Calabresa assada', 'Alface', 'Laranja', 0),
	(49, '2024-10-23', 'quarta', 'Farofa de ovo', 'Salada', 'Banana', 0),
	(50, '2024-10-24', 'quinta', 'Feijoada', 'Farofa', 'a', 0),
	(51, '2024-10-25', 'sexta', 'Macarrão', 'Batata palha', 'Abacaxi', 0);

-- Copiando estrutura para tabela carteirinha23.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nota` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario` (`id_usuario`),
  KEY `fk_nota` (`nota`),
  CONSTRAINT `fk_nota` FOREIGN KEY (`nota`) REFERENCES `status_feedback` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.feedback: ~0 rows (aproximadamente)

-- Copiando estrutura para tabela carteirinha23.horario_padrao
CREATE TABLE IF NOT EXISTS `horario_padrao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inicio_vig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.horario_padrao: ~6 rows (aproximadamente)
REPLACE INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
	(1, '2024-07-17 07:10:38', '2024-07-18 07:11:14', '16:10:00'),
	(2, '2024-07-18 07:11:14', '2024-07-19 07:14:12', '22:11:00'),
	(3, '2024-07-19 07:14:12', '2024-07-19 07:14:33', '04:14:00'),
	(4, '2024-07-19 07:14:33', '2024-07-26 12:19:36', '09:00:00'),
	(5, '2024-07-26 12:19:36', '2024-09-16 19:26:52', '10:19:00'),
	(6, '2024-09-16 19:26:52', NULL, '21:26:00');

-- Copiando estrutura para tabela carteirinha23.justificativa
CREATE TABLE IF NOT EXISTS `justificativa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.justificativa: ~4 rows (aproximadamente)
REPLACE INTO `justificativa` (`id`, `descricao`) VALUES
	(1, 'Aula no contra turno'),
	(2, 'Transporte'),
	(3, 'Projeto/TCC/Estágio'),
	(4, 'Outro');

-- Copiando estrutura para tabela carteirinha23.notificacao
CREATE TABLE IF NOT EXISTS `notificacao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_remetente` int NOT NULL,
  `id_destinatario` int NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `assunto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensagem` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT '0',
  `transferencia` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_remetente` (`id_remetente`),
  KEY `fk_destinatario` (`id_destinatario`),
  KEY `fk_transferencia_notification` (`transferencia`),
  CONSTRAINT `fk_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_remetente` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_transferencia_notification` FOREIGN KEY (`transferencia`) REFERENCES `status_notification` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela carteirinha23.notificacao: ~5 rows (aproximadamente)
REPLACE INTO `notificacao` (`id`, `id_remetente`, `id_destinatario`, `data`, `hora`, `assunto`, `mensagem`, `lida`, `transferencia`) VALUES
	(8, 3, 2, '2025-02-04', '16:09:28', 'Transferência de Almoço', 'Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais', 1, 2),
	(11, 1, 2, '2025-02-04', '17:45:02', 'Testando notificação', 'Teste notificação', 1, 0),
	(15, 2, 3, '2025-02-04', '20:22:21', 'Transferência de Almoço', 'Saudações Botteste, o estudante Vitor fez a você uma solicitação de transferência de almoço!\n\nMotivo: nao quero mais', 1, 2),
	(16, 3, 2, '2025-02-04', '20:40:38', 'Transferência de Almoço', 'Saudações Vitor, o estudante Botteste fez a você uma solicitação de transferência de almoço!\n\nMotivo: Passei mal e tive que ir embora', 1, 2),
	(17, 1, 2, '2025-02-05', '06:23:10', 'Testando novas notificações', 'lorem ipsum.', 1, 0);

-- Copiando estrutura para tabela carteirinha23.refeicao
CREATE TABLE IF NOT EXISTS `refeicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_cardapio` int NOT NULL,
  `id_status_ref` int NOT NULL,
  `id_justificativa` int DEFAULT NULL,
  `data_solicitacao` date NOT NULL,
  `hora_solicitacao` time NOT NULL,
  `outra_justificativa` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `motivo_cancelamento` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_cardapio` (`id_cardapio`),
  KEY `id_status` (`id_status_ref`),
  KEY `id_justificativa` (`id_justificativa`),
  CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`),
  CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`id_status_ref`) REFERENCES `status_ref` (`id`),
  CONSTRAINT `refeicao_ibfk_4` FOREIGN KEY (`id_justificativa`) REFERENCES `justificativa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.refeicao: ~12 rows (aproximadamente)
REPLACE INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `hora_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
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

-- Copiando estrutura para tabela carteirinha23.status_feedback
CREATE TABLE IF NOT EXISTS `status_feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.status_feedback: ~5 rows (aproximadamente)
REPLACE INTO `status_feedback` (`id`, `descricao`) VALUES
	(1, 'Muito Ruim'),
	(2, 'Ruim'),
	(3, 'Neutro'),
	(4, 'Bom'),
	(5, 'Muito bom');

-- Copiando estrutura para tabela carteirinha23.status_msg
CREATE TABLE IF NOT EXISTS `status_msg` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Copiando dados para a tabela carteirinha23.status_msg: ~2 rows (aproximadamente)
REPLACE INTO `status_msg` (`id`, `descricao`) VALUES
	(1, 'Lida'),
	(2, 'Não Lida');

-- Copiando estrutura para tabela carteirinha23.status_notification
CREATE TABLE IF NOT EXISTS `status_notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela carteirinha23.status_notification: ~5 rows (aproximadamente)
REPLACE INTO `status_notification` (`id`, `descricao`) VALUES
	(0, 'Sem transferência'),
	(1, 'Em processo\r\n'),
	(2, 'Transferida'),
	(3, 'Cancelada'),
	(5, 'Cancelada por tempo');

-- Copiando estrutura para tabela carteirinha23.status_ref
CREATE TABLE IF NOT EXISTS `status_ref` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.status_ref: ~4 rows (aproximadamente)
REPLACE INTO `status_ref` (`id`, `descricao`) VALUES
	(1, 'Agendada'),
	(2, 'Cancelada'),
	(3, 'Confirmada'),
	(4, 'Não compareceu');

-- Copiando estrutura para tabela carteirinha23.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `matricula` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `categoria` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.usuario: ~3 rows (aproximadamente)
REPLACE INTO `usuario` (`id`, `nome`, `email`, `matricula`, `senha`, `categoria`, `telefone`) VALUES
	(1, 'root', 'root@gmail.com', '20201180041', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
	(2, 'vitor', 'vitor@gmail.com', '20201180046', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00'),
	(3, 'botteste', 'botteste@gmail.com', '20201180011', '202cb962ac59075b964b07152d234b70', 'estudante', '75982777354');

-- Copiando estrutura para trigger carteirinha23.trg01_refeicao
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg01_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.id_status_ref = 1//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger carteirinha23.trg02_refeicao
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg02_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.data_solicitacao = CONVERT_TZ(NOW(),'+00:00', '+00:00')//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
