CREATE DATABASE saguadim;

USE saguadim;

-- Criação da tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios(
    usu_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usu_login VARCHAR(20) NOT NULL,
    usu_senha VARCHAR(50) NOT NULL,
    usu_status CHAR(1),
    usu_key VARCHAR(10)
);

-- Criação da tabela de cliente
CREATE TABLE IF NOT EXISTS clientes(
    cli_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cli_nome VARCHAR(50) NOT NULL,
    cli_email VARCHAR(100) NOT NULL,
    cli_telefone BIGINT NOT NULL,
    cli_cpf VARCHAR(20) NOT NULL,
    cli_curso VARCHAR(50) NOT NULL,
    cli_sala INT NOT NULL,
    cli_status CHAR(1) NOT NULL,
    cli_saldo FLOAT(10, 5) NOT NULL
);

-- Criação da tabela de produto
CREATE TABLE IF NOT EXISTS produtos(
    pro_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pro_nome VARCHAR(100) NOT NULL,
    pro_descricao VARCHAR(150) NOT NULL,
    pro_custo DECIMAL(10, 2) NOT NULL,
    pro_preco DECIMAL(10, 2) NOT NULL,
    pro_quantidade INT NOT NULL,
    pro_validade DATE NOT NULL,
    fk_fornecedor_id INT NOT NULL,
    pro_status CHAR(1)
);

-- Criação da tabela de encomenda
CREATE TABLE IF NOT EXISTS encomendas(
    enc_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    enc_emissao DATETIME NOT NULL,
    enc_entrega DATETIME NOT NULL,
    fk_pro_id INT NOT NULL,
    fk_cli_id INT NOT NULL,
    fk_ven_id INT NOT NULL, 
    enc_status CHAR(1)
);

-- Criação da tabela de venda
CREATE TABLE IF NOT EXISTS vendas(
    ven_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ven_data DATETIME NOT NULL,
    fk_cli_id INT NOT NULL,
    fk_iv_codigo INT NOT NULL,
    ven_total DECIMAL(10, 2) NOT NULL
);

-- Criação da tabela de item da venda
CREATE TABLE IF NOT EXISTS item_venda(
    iv_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    iv_quantidade INT NOT NULL,
    iv_total DECIMAL(10, 2) NOT NULL,
    iv_codigo VARCHAR(50) NOT NULL,
    fk_pro_id INT NOT NULL
);

-- Criação da tabela de log
CREATE TABLE IF NOT EXISTS tab_log(
    tab_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tab_query TEXT NOT NULL
);

-- Criação da tabela de fornecedor
CREATE TABLE IF NOT EXISTS fornecedores(
    fornecedor_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fornecedor_nome VARCHAR(50) NOT NULL
);

-- Chaves estrangeiras

-- Chave produto
ALTER TABLE produtos ADD CONSTRAINT fornecedor_produto FOREIGN KEY (fk_fornecedor_id) REFERENCES fornecedores(fornecedor_id);

-- Chaves encomenda
ALTER TABLE encomendas ADD CONSTRAINT produto_encomenda FOREIGN KEY (fk_pro_id) REFERENCES produtos(pro_id);
ALTER TABLE encomendas ADD CONSTRAINT cliente_encomenda FOREIGN KEY (fk_cli_id) REFERENCES clientes(cli_id);
ALTER TABLE encomendas ADD CONSTRAINT venda_encomenda FOREIGN KEY (fk_ven_id) REFERENCES vendas(ven_id);

-- Chave venda
ALTER TABLE vendas ADD CONSTRAINT cliente_venda FOREIGN KEY (fk_cli_id) REFERENCES clientes(cli_id);

-- Chave item venda
ALTER TABLE item_venda ADD CONSTRAINT produto_item_venda FOREIGN KEY (fk_pro_id) REFERENCES produtos(pro_id);