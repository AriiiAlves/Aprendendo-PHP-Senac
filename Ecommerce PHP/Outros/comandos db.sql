CREATE DATABASE ecommerce_ariel;

# TABELA USUARIOS

CREATE TABLE usuarios(
	usu_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(50) NOT NULL,
    usu_senha VARCHAR(50) NOT NULL,
    usu_ativo CHAR(1) NOT NULL,
    usu_tempero VARCHAR(300) NOT NULL
);

# CRIAÇÃO DE USUÁRIO

CREATE USER 'adm'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'adm'@'localhost';
FLUSH PRIVILEGES;

# TABELA PRODUTOS

USE ecommerce_ariel;

CREATE TABLE produtos(
    pd_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    pd_nome VARCHAR(100) NOT NULL,
    pd_desc TEXT NOT NULL,
    pd_quant INT NOT NULL,
    pd_valor FLOAT NOT NULL,
    pd_ativo CHAR(1) NOT NULL,
    pd_img TEXT
);

# TABELA CLIENTE

USE ecommerce_ariel;

CREATE TABLE clientes(
    cli_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cli_cpf BIGINT(20) NOT NULL,
    cli_nome VARCHAR(50) NOT NULL,
    cli_senha VARCHAR(50) NOT NULL,
    cli_datanasc DATE NOT NULL,
    cli_telefone BIGINT(20) NOT NULL,
    cli_logradouro VARCHAR(100) NOT NULL,
    cli_numero VARCHAR(10) NOT NULL,
    cli_cidade VARCHAR(50) NOT NULL,
    cli_ativo CHAR(1) NOT NULL,
    cli_tempero VARCHAR(300) NOT NULL,
    cli_email VARCHAR(100) NOT NULL,
    cli_recupera INT(6) NOT NULL
);