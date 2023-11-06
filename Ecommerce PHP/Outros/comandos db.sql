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