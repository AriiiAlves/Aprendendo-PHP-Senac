<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usu_id = $_POST['usu_id'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $status = $_POST['status'];

    // Edita os dados do usuário
    $sql = "UPDATE usuarios SET 
        usu_login = '$login',
        usu_email = '$email',
        usu_senha = '$senha',
        usu_status = '$status'
        WHERE usu_id = $usu_id";
    mysqli_query($link, $sql);
    echo "1";
}

?>