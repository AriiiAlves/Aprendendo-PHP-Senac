<?php
include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $curso = $_POST['curso'];
    $sala = $_POST['sala'];

    # Inserir instruções no banco
    $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email' OR cli_cpf = '$cpf'";
    $resultado = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($resultado)[0];

    # Grava Log
    $sql = '"' . $sql . '"';
    $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
        VALUES ($sql, NOW())";
    mysqli_query($link, $sqllog);

    # Verifica se o usuário já existe
    if($resultado >= 1){
        echo "0";
    }
    else{
        // Se não existe, cria o cliente novo no banco
        $sql = "INSERT INTO clientes(cli_nome, cli_email, cli_senha, cli_telefone, cli_cpf, cli_curso, cli_sala, cli_status, cli_saldo) 
            VALUES('$nome', '$email', '$senha', '$telefone', '$cpf', '$curso', $sala, 's', 0)";
        mysqli_query($link, $sql);

        echo "1";
    }
}

exit();

?>