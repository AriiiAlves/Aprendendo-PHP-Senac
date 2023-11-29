<?php
include("cabecalho.php");

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
        echo "<script>window.alert('Email já cadastrado.')</script>";
        echo "<script>window.location.href='cadastrausuario.php'</script>";
    }
    else{
        $sql = "INSERT INTO usuarios(usu_login, usu_senha, usu_status, usu_key, usu_email) VALUES('$login', '$senha', 's', '$key', '$email')";
        mysqli_query($link, $sql);

        echo "<script>window.alert('Usuário cadastrado.')</script>";
        echo "<script>window.location.href='listausuario.php'</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="cadastraproduto.css">
</head>
<body>
    <div class="container">
        <h2 class="titulo">Cadastro de Usuário</h2>
        <form action="cadastrausuario.php" method="post">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" placeholder="Login" required>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="email@email.com" required>
            <label for="password">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="*********" required>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>