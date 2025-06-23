-- -----------------------------------------------------
-- SCRIPT PARA CRIAÇÃO DO BANCO DE DADOS E TABELAS FITFOOD (MySQL)
-- -----------------------------------------------------

-- Cria o banco de dados com o conjunto de caracteres recomendado para aplicações web
CREATE DATABASE IF NOT EXISTS `fitfood` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `fitfood`;

-- Desativa a verificação de chaves estrangeiras para permitir a exclusão das tabelas em qualquer ordem
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `dieta_refeicoes`;
DROP TABLE IF EXISTS `refeicao_alimentos`;
DROP TABLE IF EXISTS `dietas`;
DROP TABLE IF EXISTS `refeicoes`;
DROP TABLE IF EXISTS `alimentos`;
DROP TABLE IF EXISTS `tipos_refeicao`;
DROP TABLE IF EXISTS `pacientes`;
DROP TABLE IF EXISTS `nutricionistas`;
SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------
-- Tabela `nutricionistas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nutricionistas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL COMMENT 'Armazenar usando password_hash() do PHP',
  `crn` VARCHAR(20) NULL,
  `telefone` VARCHAR(20) NULL,
  `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `pacientes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nutricionista_id` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `chave_acesso` VARCHAR(10) NOT NULL,
  `data_nascimento` DATE NULL,
  `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_pacientes_nutricionistas_idx` (`nutricionista_id` ASC),
  CONSTRAINT `fk_pacientes_nutricionistas`
    FOREIGN KEY (`nutricionista_id`)
    REFERENCES `nutricionistas` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `tipos_refeicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipos_refeicao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `alimentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `alimentos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL UNIQUE,
  `calorias` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `proteinas` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `carboidratos` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `gorduras` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `fibras` DECIMAL(10,2) NULL DEFAULT 0.00,
  `sodio` DECIMAL(10,2) NULL DEFAULT 0.00,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `refeicoes` (Templates de refeições criadas pelos nutris)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `refeicoes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `tipo_refeicao_id` INT NOT NULL,
  `nutricionista_criador_id` INT NULL COMMENT 'Opcional: ID do nutri que criou esta receita modelo',
  `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_refeicoes_tipos_refeicao_idx` (`tipo_refeicao_id` ASC),
  INDEX `fk_refeicoes_nutricionistas_idx` (`nutricionista_criador_id` ASC),
  CONSTRAINT `fk_refeicoes_tipos_refeicao`
    FOREIGN KEY (`tipo_refeicao_id`)
    REFERENCES `tipos_refeicao` (`id`),
  CONSTRAINT `fk_refeicoes_nutricionistas`
    FOREIGN KEY (`nutricionista_criador_id`)
    REFERENCES `nutricionistas` (`id`)
    ON DELETE SET NULL)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `dietas` (Plano alimentar específico para um paciente)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dietas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `paciente_id` INT NOT NULL,
  `nutricionista_id` INT NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NULL,
  `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_dietas_pacientes_idx` (`paciente_id` ASC),
  INDEX `fk_dietas_nutricionistas_idx` (`nutricionista_id` ASC),
  CONSTRAINT `fk_dietas_pacientes`
    FOREIGN KEY (`paciente_id`)
    REFERENCES `pacientes` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_dietas_nutricionistas`
    FOREIGN KEY (`nutricionista_id`)
    REFERENCES `nutricionistas` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `refeicao_alimentos` (Tabela de junção N-para-N)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `refeicao_alimentos` (
  `refeicao_id` INT NOT NULL,
  `alimento_id` INT NOT NULL,
  `quantidade_gramas` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`refeicao_id`, `alimento_id`),
  INDEX `fk_refeicao_alimentos_alimentos_idx` (`alimento_id` ASC),
  CONSTRAINT `fk_refeicao_alimentos_refeicoes`
    FOREIGN KEY (`refeicao_id`)
    REFERENCES `refeicoes` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_refeicao_alimentos_alimentos`
    FOREIGN KEY (`alimento_id`)
    REFERENCES `alimentos` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Tabela `dieta_refeicoes` (Tabela de junção N-para-N)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dieta_refeicoes` (
  `dieta_id` INT NOT NULL,
  `refeicao_id` INT NOT NULL,
  PRIMARY KEY (`dieta_id`, `refeicao_id`),
  INDEX `fk_dieta_refeicoes_refeicoes_idx` (`refeicao_id` ASC),
  CONSTRAINT `fk_dieta_refeicoes_dietas`
    FOREIGN KEY (`dieta_id`)
    REFERENCES `dietas` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_dieta_refeicoes_refeicoes`
    FOREIGN KEY (`refeicao_id`)
    REFERENCES `refeicoes` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- INSERÇÃO DE DADOS INICIAIS (SEED)
-- -----------------------------------------------------

-- Povoando Tipos de Refeição
INSERT INTO `tipos_refeicao` (`id`, `nome`) VALUES
(1, 'Café da manhã'),
(2, 'Colação'),
(3, 'Almoço'),
(4, 'Lanche'),
(5, 'Jantar'),
(6, 'Ceia');

-- Povoando Alimentos
INSERT INTO `alimentos` (`id`, `nome`, `calorias`, `proteinas`, `carboidratos`, `gorduras`, `fibras`, `sodio`) VALUES
(1, 'Aveia em Flocos', 382.00, 15.70, 63.80, 9.20, 9.38, 4.59),
(2, 'Banana Prata', 107.00, 1.11, 25.90, 0.28, 1.95, 0.00),
(3, 'Leite Desnatado', 34.00, 3.40, 5.00, 0.10, 0.00, 50.00),
(4, 'Maçã Fuji (com casca)', 59.00, 0.29, 15.20, 0.00, 1.35, 0.00),
(5, 'Iogurte Grego Tradicional', 110.00, 5.44, 15.56, 2.89, 0.00, 46.67),
(6, 'Peito de Frango Grelhado', 95.00, 17.50, 3.25, 1.25, 0.00, 640.00),
(7, 'Arroz Integral Cozido', 111.00, 2.60, 23.00, 0.90, 1.80, 1.00),
(8, 'Brócolis Cozido', 27.00, 2.71, 4.44, 0.54, 3.28, 130.00),
(9, 'Pão Integral', 221.00, 7.60, 39.90, 3.00, 7.40, 496.00),
(10, 'Queijo Minas Padrão', 303.33, 23.33, 0.00, 23.33, 0.00, 600.00),
(11, 'Salmão Grelhado', 153.00, 24.58, 0.00, 5.28, 0.00, 90.00),
(12, 'Batata Doce Cozida', 76.00, 1.40, 17.70, 0.10, 2.50, 67.00),
(13, 'Aspargos Cozidos', 20.00, 2.20, 2.20, 0.00, 1.20, 2.00),
(14, 'Chá de Camomila (infusão)', 1.00, 0.00, 0.28, 0.01, 0.00, 1.00);

-- Povoando Refeições Modelo
INSERT INTO `refeicoes` (`id`, `nome`, `tipo_refeicao_id`) VALUES
(1, 'Mingau de Aveia com Banana e Leite', 1),
(2, 'Maçã com Iogurte Grego', 2),
(3, 'Frango Grelhado com Arroz Integral e Brócolis', 3),
(4, 'Sanduíche de Queijo Minas em Pão Integral', 4),
(5, 'Salmão Grelhado com Batata Doce e Aspargos', 5),
(6, 'Chá de Camomila com Leite', 6);

-- Povoando a junção de refeições e alimentos
INSERT INTO `refeicao_alimentos` (`refeicao_id`, `alimento_id`, `quantidade_gramas`) VALUES
-- Café da Manhã (ID 1)
(1, 1, 30), (1, 2, 80), (1, 3, 200),
-- Colação (ID 2)
(2, 4, 130), (2, 5, 90),
-- Almoço (ID 3)
(3, 6, 150), (3, 7, 150), (3, 8, 100),
-- Lanche (ID 4)
(4, 9, 50), (4, 10, 30),
-- Jantar (ID 5)
(5, 11, 125), (5, 12, 150), (5, 13, 100),
-- Ceia (ID 6)
(6, 3, 200), (6, 14, 200);

-- -----------------------------------------------------
-- Tabela `paciente_receitas` (Receitas específicas para pacientes)
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `paciente_receitas` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `paciente_id` INT NOT NULL,
  `refeicao_id` INT NOT NULL,
  `data_atribuicao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `observacoes` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_paciente_receitas_pacientes_idx` (`paciente_id` ASC),
  INDEX `fk_paciente_receitas_refeicoes_idx` (`refeicao_id` ASC),
  CONSTRAINT `fk_paciente_receitas_pacientes`
    FOREIGN KEY (`paciente_id`)
    REFERENCES `pacientes` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_paciente_receitas_refeicoes`
    FOREIGN KEY (`refeicao_id`)
    REFERENCES `refeicoes` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB;

-- FIM DO SCRIPT