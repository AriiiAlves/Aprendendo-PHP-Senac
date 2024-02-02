<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cli_id = $_POST['cli_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];
    $curso = $_POST['curso'];
    $sala = $_POST['sala'];
    $status = $_POST['status'];
    $saldo = $_POST['saldo'];

    // Edita os dados do cliente
    $sql = "UPDATE clientes SET 
        cli_nome = '$nome',
        cli_email = '$email',
        cli_senha = '$senha',
        cli_telefone = '$telefone',
        cli_cpf = '$cpf',
        cli_curso = '$curso',
        cli_sala = $sala,
        cli_status = '$status',
        cli_saldo = $saldo

        WHERE cli_id = $cli_id";
    mysqli_query($link, $sql);
    echo "1";
}

?>