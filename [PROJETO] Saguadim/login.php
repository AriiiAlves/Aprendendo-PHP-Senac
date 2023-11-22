<?php

# Inicia variável de sessão
session_start();

# Inclui dados de conexão do banco
include("conectadb.php");

# Após click no POST
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    # Query de validação se o usuário existe
    $sql = "SELECT COUNT(usu_id) FROM usuarios 
        WHERE usu_email = '$email' 
        AND usu_senha = '$senha' 
        AND usu_status = 's'";
    $retorno = mysqli_query($link, $sql);

    # Grava Log
    $sql = '"' . $sql . '"';
    $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
        VALUES ($sql, NOW())";

    mysqli_query($link, $sqllog);

    while ($tbl = mysqli_fetch_array($retorno)){
        $resultado = $tbl[0];
    }

    if ($resultado == 0){
        echo("<script>window.alert('Usuário ou senha incorretos.');</script>");
        echo "<script>window.location.href='login.html'</script>";
    }
    else{
        $sql = "SELECT * FROM usuarios 
        WHERE usu_email = '$email'
        AND usu_senha = '$senha'
        AND usu_status = 's'";
        $retorno = mysqli_query($link, $sql);

        # Grava Log
        $sql = '"' . $sql . '"';
        $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
            VALUES ($sql, NOW())";
        mysqli_query($link, $sqllog);
        
        while ($tbl = mysqli_fetch_array($retorno)){
            $_SESSION['idusuario'] = $tbl[0];
            $_SESSION['nomeusuario'] = $tbl[1];
        }

        echo("<script>window.location.href='backoffice.php';</script>");
    }
}

?>