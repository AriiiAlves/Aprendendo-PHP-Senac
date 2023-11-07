<?php

include("Conexão com banco.php");

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $email = $_POST['email'];

    $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if($cont > 0){
        $codigo = rand(111111, 999999);
        $sql = "UPDATE clientes SET cli_recupera = $codigo WHERE cli_email = '$email'";
        $cont = mysqli_query($link, $sql)[0];
        # Enviar código por email (não feito)
        echo "<script> window.location.href='Confirmar Código.php?email=$email'; </script>";
    }
    else{
        echo "<script> window.alert('O email não está associado a nenhuma conta.'); </script>";
        echo "<script> window.location.href='Esqueci minha senha.php'; </script>";
    }
}


?>


<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/Visão Adm.css">
        <title>Redefinir Senha</title>
    </head>
    <body>
        <form action="Esqueci minha senha.php" method="POST">
            <h1>Redefinir com email</h1>
            <input type="text" name="email" id="email" placeholder="Email" required>
            <p></p>
            <input type="submit" name="login" value="Enviar código">
            <p></p>
            <a href="Login Cliente.php" style="text-decoration: none;">Voltar para Login</a><br><br>
        </form>
    </body>
</html>