<?php

# Inicia a conexão com o banco de dados
include("Conexão com banco.php");

# Coleta de variáveis via formulário de HTML
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    # Passando instruções SQL para o banco
    # Validando se o usuário já existe
    $query = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome'";
    $retorno_da_query = mysqli_query($link, $query);
    while ($array = mysqli_fetch_array($retorno_da_query)){
        $cont = $array[0];
    }

    # Se o usuário já existe, retorna uma mensagem ao usuário. Se não, cadastra o usuário.
    if ($cont > 0){
        echo "<script> window.alert('Usuário já cadastrado!'); </script>";
    }
    else{
        $query = "INSERT INTO usuarios(usu_nome, usu_senha, usu_ativo) VALUES('$nome', '$senha', 'n')";
        mysqli_query($link, $query);
        echo "<script> window.alert('Usuário cadastrado com sucesso!'); </script>";
        echo "<script> window.location.href='Cadastro Cliente.php'; </script>";
    }
}

?>

<html>
    <head>
        <link rel="stylesheet" href="./Css/Cadastro.css">
        <title> Cadastro de usuário </title>
    </head>
    <body>
        <div>
            <form action="Cadastro Cliente.php" method="post">
                <h3>Cadastro de cliente</h3>
                <input type="text" name="nome" id="nome" placeholder="Nome de usuário">
                <p></p>
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <p></p>
                <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
                <p></p>
            </form>
        </div>
    </body>
</html>