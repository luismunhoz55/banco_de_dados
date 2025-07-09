CREATE DATABASE IF NOT EXISTS trabalhobd;
USE trabalhobd;

CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    senha VARCHAR(255),
    tipo VARCHAR(50),
    deleted_at DATETIME
);

CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nome_empresa VARCHAR(255),
    cnpj VARCHAR(20),
    telefone VARCHAR(20),
    deleted_at DATETIME
);

CREATE TABLE categorias (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255)
);

CREATE TABLE prioridades (
    id_prioridade INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    cor VARCHAR(20)
);

CREATE TABLE chamados (
    id_chamado INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(255),
    descricao TEXT,
    data_abertura DATETIME,
    data_encerramento DATETIME,
    prazo_resolucao DATETIME,
    status VARCHAR(50),
    id_usuario_solicitante INT,
    id_usuario_responsavel INT,
    id_cliente INT NOT NULL,
    id_categoria INT,
    id_prioridade INT,
    deleted_at DATETIME,
    FOREIGN KEY (id_usuario_solicitante) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_usuario_responsavel) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_prioridade) REFERENCES prioridades(id_prioridade)
);

CREATE TABLE acompanhamentos (
    id_acompanhamento INT PRIMARY KEY AUTO_INCREMENT,
    id_chamado INT NOT NULL,
    texto TEXT,
    data_hora DATETIME,
    id_usuario INT NOT NULL,
    deleted_at DATETIME,
    FOREIGN KEY (id_chamado) REFERENCES chamados(id_chamado),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE historico_status (
    id_historico INT PRIMARY KEY AUTO_INCREMENT,
    id_chamado INT NOT NULL,
    status VARCHAR(50),
    data DATETIME,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_chamado) REFERENCES chamados(id_chamado),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE anexos (
    id_anexo INT PRIMARY KEY AUTO_INCREMENT,
    nome_arquivo VARCHAR(255),
    caminho VARCHAR(255),
    tipo VARCHAR(50),
    id_acompanhamento INT,
    id_chamado INT,
    deleted_at DATETIME,
    FOREIGN KEY (id_acompanhamento) REFERENCES acompanhamentos(id_acompanhamento),
    FOREIGN KEY (id_chamado) REFERENCES chamados(id_chamado)
);

CREATE TABLE avaliacoes (
    id_avaliacao INT PRIMARY KEY AUTO_INCREMENT,
    id_chamado INT NOT NULL,
    nota INT,
    comentario TEXT,
    data DATETIME,
    FOREIGN KEY (id_chamado) REFERENCES chamados(id_chamado)
);

CREATE TABLE log_usuarios (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    acao VARCHAR(255),
    data_hora DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

ALTER TABLE chamados
  ADD CONSTRAINT chk_status CHECK (status IN ('aberto', 'em andamento', 'concluido', 'cancelado'));

ALTER TABLE usuarios
  ADD CONSTRAINT chk_tipo CHECK (tipo IN ('admin', 'tecnico', 'cliente'));

ALTER TABLE avaliacoes
  ADD CONSTRAINT chk_nota CHECK (nota BETWEEN 1 AND 5);

ALTER TABLE prioridades
  ADD CONSTRAINT chk_cor CHECK (cor REGEXP '^#[0-9A-Fa-f]{6}$'); -- cor hexadecimal, ex: #FF0000

  -- Criar usuário admin
CREATE USER 'admin_user'@'localhost' IDENTIFIED BY 'admin123';
GRANT ALL PRIVILEGES ON *.* TO 'admin_user'@'localhost';

-- Criar usuário limitado (consulta + inserção)
CREATE USER 'user_read_write'@'localhost' IDENTIFIED BY 'user123';
GRANT SELECT, INSERT ON sua_base_de_dados.* TO 'user_read_write'@'localhost';

-- usuarios
INSERT INTO usuarios (nome, email, senha, tipo) VALUES
('Ana Silva', 'ana@example.com', 'senha123', 'admin'),
('Carlos Souza', 'carlos@example.com', 'senha123', 'tecnico');

-- clientes
INSERT INTO clientes (nome_empresa, cnpj, telefone) VALUES
('Empresa X', '12345678000100', '11999999999'),
('Empresa Y', '98765432000100', '11888888888');

-- categorias
INSERT INTO categorias (nome) VALUES ('Infraestrutura'), ('Software');

-- prioridades
INSERT INTO prioridades (nome, cor) VALUES
('Alta', '#FF0000'), ('Baixa', '#00FF00');

-- chamados
INSERT INTO chamados (titulo, descricao, data_abertura, status, id_usuario_solicitante, id_usuario_responsavel, id_cliente, id_categoria, id_prioridade) VALUES
('Internet lenta', 'Usuário reclama de lentidão', NOW(), 'aberto', 1, 2, 1, 1, 1),
('Erro no sistema', 'Sistema não carrega tela inicial', NOW(), 'aberto', 1, 2, 2, 2, 2);

-- acompanhamentos
INSERT INTO acompanhamentos (id_chamado, texto, data_hora, id_usuario) VALUES
(1, 'Análise inicial realizada', NOW(), 2),
(2, 'Reiniciado o serviço', NOW(), 2);

-- anexos
INSERT INTO anexos (nome_arquivo, caminho, tipo, id_chamado) VALUES
('screenshot1.png', '/uploads/screenshot1.png', 'imagem', 1),
('log.txt', '/uploads/log.txt', 'texto', 2);

-- historico_status
INSERT INTO historico_status (id_chamado, status, data, id_usuario) VALUES
(1, 'em andamento', NOW(), 2),
(1, 'concluido', NOW(), 2);

-- avaliacoes
INSERT INTO avaliacoes (id_chamado, nota, comentario, data) VALUES
(1, 5, 'Atendimento ótimo', NOW()),
(2, 3, 'Resolveu, mas demorou', NOW());

-- log_usuarios
INSERT INTO log_usuarios (id_usuario, acao, data_hora) VALUES
(1, 'Login', NOW()),
(2, 'Alterou chamado', NOW());

