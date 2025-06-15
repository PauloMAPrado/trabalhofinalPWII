CREATE DATABASE IF NOT EXISTS fitfood

USE fitfood;

DROP TABLE IF EXISTS Dieta_Refeicoes;
DROP TABLE IF EXISTS Refeicao_Alimentos;
DROP TABLE IF EXISTS Dietas;
DROP TABLE IF EXISTS Refeicoes;
DROP TABLE IF EXISTS Alimentos;
DROP TABLE IF EXISTS TiposRefeicao;
DROP TABLE IF EXISTS Usuarios;
GO

CREATE TABLE Usuarios (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Nome NVARCHAR(255) NOT NULL,
    Email NVARCHAR(255) NOT NULL UNIQUE,
    Senha NVARCHAR(MAX) NOT NULL,
    DataCriacao DATETIME2 NOT NULL DEFAULT GETDATE()
);
PRINT 'Tabela Usuarios criada com sucesso.';
GO

CREATE TABLE TiposRefeicao (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Nome NVARCHAR(100) NOT NULL UNIQUE
);
PRINT 'Tabela TiposRefeicao criada com sucesso.';
GO

CREATE TABLE Alimentos (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Nome NVARCHAR(255) NOT NULL UNIQUE,
    Calorias DECIMAL(10, 2) NOT NULL,
    Proteinas DECIMAL(10, 2) NOT NULL,
    Carboidratos DECIMAL(10, 2) NOT NULL,
    Gorduras DECIMAL(10, 2) NOT NULL,
    Fibras DECIMAL(10, 2) NOT NULL,
    Sodio DECIMAL(10, 2) NOT NULL
);
PRINT 'Tabela Alimentos criada com sucesso.';
GO

CREATE TABLE Refeicoes (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Nome NVARCHAR(255) NOT NULL,
    TipoRefeicaoId INT NOT NULL,
    DataCriacao DATETIME2 NOT NULL DEFAULT GETDATE(),
    FOREIGN KEY (TipoRefeicaoId) REFERENCES TiposRefeicao(Id)
);
PRINT 'Tabela Refeicoes criada com sucesso.';
GO

CREATE TABLE Dietas (
    Id INT PRIMARY KEY IDENTITY(1,1),
    Nome NVARCHAR(255) NOT NULL,
    UsuarioId INT NOT NULL,
    DataCriacao DATETIME2 NOT NULL DEFAULT GETDATE(),
);
PRINT 'Tabela Dietas criada com sucesso.';
GO

CREATE TABLE Refeicao_Alimentos (
    RefeicaoId INT NOT NULL,
    AlimentoId INT NOT NULL,
    QuantidadeGramas DECIMAL(10, 2) NOT NULL,
    PRIMARY KEY (RefeicaoId, AlimentoId),
    FOREIGN KEY (RefeicaoId) REFERENCES Refeicoes(Id) ON DELETE CASCADE,
    FOREIGN KEY (AlimentoId) REFERENCES Alimentos(Id) ON DELETE CASCADE
);
PRINT 'Tabela de junção Refeicao_Alimentos criada com sucesso.';
GO

CREATE TABLE Dieta_Refeicoes (
    DietaId INT NOT NULL,
    RefeicaoId INT NOT NULL,
    PRIMARY KEY (DietaId, RefeicaoId),
    FOREIGN KEY (DietaId) REFERENCES Dietas(Id) ON DELETE CASCADE,
    FOREIGN KEY (RefeicaoId) REFERENCES Refeicoes(Id) ON DELETE CASCADE
);
PRINT 'Tabela de junção Dieta_Refeicoes criada com sucesso.';
GO

INSERT INTO TiposRefeicao (Nome) VALUES
('Café da manhã'),
('Colação'),
('Almoço'),
('Lanche'),
('Jantar'),
('Ceia');
PRINT 'Tabela TiposRefeicao populada com os 6 tipos de refeição padrão.';
GO

INSERT INTO Alimentos (Nome, Calorias, Proteinas, Carboidratos, Gorduras, Fibras, Sodio) VALUES
('Aveia em Flocos', 382.00, 15.70, 63.80, 9.20, 9.38, 4.59),
('Banana Prata', 107.00, 1.11, 25.90, 0.28, 1.95, 0.00),
('Leite Desnatado', 34.00, 3.40, 5.00, 0.10, 0.00, 50.00),
('Maçã Fuji (com casca)', 59.00, 0.29, 15.20, 0.00, 1.35, 0.00),
('Iogurte Grego Tradicional', 110.00, 5.44, 15.56, 2.89, 0.00, 46.67),
('Peito de Frango Grelhado', 95.00, 17.50, 3.25, 1.25, 0.00, 640.00),
('Arroz Integral Cozido', 111.00, 2.60, 23.00, 0.90, 1.80, 1.00)
('Brócolis Cozido', 27.00, 2.71, 4.44, 0.54, 3.28, 130.00),
('Pão Integral', 221.00, 7.60, 39.90, 3.00, 7.40, 496.00),
('Queijo Minas Padrão', 303.33, 23.33, 0.00, 23.33, 0.00, 600.00),
('Salmão Grelhado', 153.00, 24.58, 0.00, 5.28, 0.00, 90.00),
('Batata Doce Cozida', 76.00, 1.40, 17.70, 0.10, 2.50, 67.00),
('Aspargos Cozidos', 20.00, 2.20, 2.20, 0.00, 1.20, 2.00),
('Chá de Camomila (infusão)', 1.00, 0.00, 0.28, 0.01, 0.00, 1.00);
PRINT 'Tabela Alimentos populada com 14 ingredientes para as receitas.';
GO

DECLARE @IdRefeicaoCafeManha INT, @IdRefeicaoColacao INT, @IdRefeicaoAlmoco INT, @IdRefeicaoLanche INT, @IdRefeicaoJantar INT, @IdRefeicaoCeia INT;
DECLARE @IdAlimentoAveia INT, @IdAlimentoBanana INT, @IdAlimentoLeite INT, @IdAlimentoMaca INT, @IdAlimentoIogurte INT;
DECLARE @IdAlimentoFrango INT, @IdAlimentoArroz INT, @IdAlimentoBrocolis INT, @IdAlimentoPao INT, @IdAlimentoQueijo INT;
DECLARE @IdAlimentoSalmao INT, @IdAlimentoBatataDoce INT, @IdAlimentoAspargos INT, @IdAlimentoCamomila INT;

SELECT @IdAlimentoAveia = Id FROM Alimentos WHERE Nome = 'Aveia em Flocos';
SELECT @IdAlimentoBanana = Id FROM Alimentos WHERE Nome = 'Banana Prata';
SELECT @IdAlimentoLeite = Id FROM Alimentos WHERE Nome = 'Leite Desnatado';
SELECT @IdAlimentoMaca = Id FROM Alimentos WHERE Nome = 'Maçã Fuji (com casca)';
SELECT @IdAlimentoIogurte = Id FROM Alimentos WHERE Nome = 'Iogurte Grego Tradicional';
SELECT @IdAlimentoFrango = Id FROM Alimentos WHERE Nome = 'Peito de Frango Grelhado';
SELECT @IdAlimentoArroz = Id FROM Alimentos WHERE Nome = 'Arroz Integral Cozido';
SELECT @IdAlimentoBrocolis = Id FROM Alimentos WHERE Nome = 'Brócolis Cozido';
SELECT @IdAlimentoPao = Id FROM Alimentos WHERE Nome = 'Pão Integral';
SELECT @IdAlimentoQueijo = Id FROM Alimentos WHERE Nome = 'Queijo Minas Padrão';
SELECT @IdAlimentoSalmao = Id FROM Alimentos WHERE Nome = 'Salmão Grelhado';
SELECT @IdAlimentoBatataDoce = Id FROM Alimentos WHERE Nome = 'Batata Doce Cozida';
SELECT @IdAlimentoAspargos = Id FROM Alimentos WHERE Nome = 'Aspargos Cozidos';
SELECT @IdAlimentoCamomila = Id FROM Alimentos WHERE Nome = 'Chá de Camomila (infusão)';

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Mingau de Aveia com Banana e Leite', 1);
SET @IdRefeicaoCafeManha = SCOPE_IDENTITY(); -- Captura o ID da refeição recém-inserida

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoCafeManha, @IdAlimentoAveia, 30),
(@IdRefeicaoCafeManha, @IdAlimentoBanana, 80),
(@IdRefeicaoCafeManha, @IdAlimentoLeite, 200);
PRINT 'Receita de Café da Manhã inserida com sucesso.';
GO

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Maçã com Iogurte Grego', 2);
SET @IdRefeicaoColacao = SCOPE_IDENTITY();

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoColacao, @IdAlimentoMaca, 130),
(@IdRefeicaoColacao, @IdAlimentoIogurte, 90);
PRINT 'Receita de Colação inserida com sucesso.';
GO

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Frango Grelhado com Arroz Integral e Brócolis', 3);
SET @IdRefeicaoAlmoco = SCOPE_IDENTITY();

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoAlmoco, @IdAlimentoFrango, 150),
(@IdRefeicaoAlmoco, @IdAlimentoArroz, 150),
(@IdRefeicaoAlmoco, @IdAlimentoBrocolis, 100);
PRINT 'Receita de Almoço inserida com sucesso.';
GO

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Sanduíche de Queijo Minas em Pão Integral', 4);
SET @IdRefeicaoLanche = SCOPE_IDENTITY();

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoLanche, @IdAlimentoPao, 50),
(@IdRefeicaoLanche, @IdAlimentoQueijo, 30);
PRINT 'Receita de Lanche inserida com sucesso.';
GO

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Salmão Grelhado com Batata Doce e Aspargos', 5);
SET @IdRefeicaoJantar = SCOPE_IDENTITY();

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoJantar, @IdAlimentoSalmao, 125),
(@IdRefeicaoJantar, @IdAlimentoBatataDoce, 150),
(@IdRefeicaoJantar, @IdAlimentoAspargos, 100);
PRINT 'Receita de Jantar inserida com sucesso.';
GO

INSERT INTO Refeicoes (Nome, TipoRefeicaoId) VALUES ('Leite Desnatado morno com Chá de Camomila', 6);
SET @IdRefeicaoCeia = SCOPE_IDENTITY();

INSERT INTO Refeicao_Alimentos (RefeicaoId, AlimentoId, QuantidadeGramas) VALUES
(@IdRefeicaoCeia, @IdAlimentoLeite, 200),
(@IdRefeicaoCeia, @IdAlimentoCamomila, 200);