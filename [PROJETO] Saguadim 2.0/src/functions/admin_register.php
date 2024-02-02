<?php
include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $login = $_POST['login'];

    $key = rand(100000, 999999);

    # Inserir instruções no banco
    $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_email = '$email' OR usu_login = '$login'";
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
        // Cria um novo usuário no banco de dados, caso ele não exista
        $sql = "INSERT INTO usuarios(usu_login, usu_senha, usu_status, usu_key, usu_email) VALUES('$login', '$senha', 's', '$key', '$email')";
        mysqli_query($link, $sql);

        echo "1";
    }
}

exit();

?>