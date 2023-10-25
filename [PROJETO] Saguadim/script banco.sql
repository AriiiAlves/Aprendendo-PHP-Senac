CREATE DATABASE saguadim;

USE saguadim;

-- Criação da tabela de usuários
CREATE TABLE usuarios(
    usu_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY;
    usu_login VARCHAR(20) NOT NULL,
    usu_senha VARCHAR(50) NOT NULL,
    usu_status CHAR(1),
    usu_key VARCHAR(10)
);

-- Criação da tabela de cliente
CREATE TABLE clientes(
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