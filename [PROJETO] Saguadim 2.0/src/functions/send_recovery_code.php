<?php

include("conectadb.php");

// O código abaixo funciona, o problema é o controle da conta do outlook que bloqueia bots e contas
// atestadas como geradoras de spam

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPmail/src/Exception.php';
require 'PHPmail/src/PHPMailer.php';
require 'PHPmail/src/SMTP.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];

    $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_email = '$email'";
    $resultado = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($resultado)[0];

    if($resultado >= 1){
        $sql = "SELECT usu_key FROM usuarios WHERE usu_email = '$email'";
        $resultado = mysqli_query($link, $sql);
        $codigo = mysqli_fetch_array($resultado)[0];

        // Envia o código por email

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

            echo "1";
        } catch (Exception $e) {
            echo "$mail->ErrorInfo";
        }
    }
    else{
        echo "0";
    }
}

?>