<?php

include("Conexão com banco.php");

$email = $_GET['email'];

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $recupera = $_POST['recupera'];

    $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email' AND cli_recupera = $recupera";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if($cont > 0){
        echo "<script> window.location.href='Redefinir Senha.php?email=$email&sucesso=false'; </script>";
    }
    else{
        echo "<script> window.alert('Código incorreto.'); </script>";
        echo "<script> window.location.href='Confirmar Código.php?email=$email'; </script>";
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
        <form action="Confirmar Código.php?email=<?=$email?>" method="POST">
            <h1>Código</h1>
            <input type="number" name="recupera" id="recupera" placeholder="Código enviado por email" min="0" max="999999" required>
            <p></p>
            <input type="submit" name="login" value="Conferir código">
            <p></p>
            <a href="Login Cliente.php" style="text-decoration: none;">Voltar para Login</a><br><br>
        </form>
    </body>
</html>