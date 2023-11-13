<?php

include("Conexão com banco.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPmail/src/Exception.php';
require 'PHPmail/src/PHPMailer.php';
require 'PHPmail/src/SMTP.php';

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $email = $_POST['email'];

    $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if($cont > 0){
        $codigo = rand(111111, 999999);
        $sql = "UPDATE clientes SET cli_recupera = $codigo WHERE cli_email = '$email'";
        $cont = mysqli_query($link, $sql)[0];

        # Envia o código por email

        // Destinatário
        $to = $email;
        // Assunto
        $subject = "Password Recovery - Ecommerce TI 26";
        // Mensagem 
        $message = "Your recovery code: $codigo. 
        <br>Acess <a href='Redefinir Senha.php?email=$email&sucesso=false'> this link </a> for recovery your password.";
        // Cria o objeto $mail a partir da classe PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arielti26teste@outlook.com'; // Mudar para seu email
            $mail->Password = 'Teste123!'; // Mudar para senha do seu seu email
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('arielti26teste@outlook.com', 'TI26 Delivery'); // Mudar para seu email
            $mail->addAddress($to); // Adiciona destinatário no email
            $mail->isHTML(true);
            $mail->Subject = $subject; // Adiciona assunto no email
            // $mail->UTF_8;
            $mail->Body = $message; // Adiciona mensagem no email
            $mail->send();

            # Vai pra tela de confirmar código
            echo "<script> window.location.href='Confirmar Código.php?email=$email'; </script>";
        } catch (Exception $e) {
            echo "<script> Não foi possível enviar a mensagem: {$mail->ErrorInfo}; </script>";
            echo "<script> window.location.href='Esqueci minha senha.php'; </script>";
        }
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