<?php

include("Conexão com banco.php");

# Coleta de variáveis via formulário de HTML
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $imagem = $_POST['imagem'];

    $query = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome'";
    $retorno_da_query = mysqli_query($link, $query);
    while ($array = mysqli_fetch_array($retorno_da_query)){
        $cont = $array[0];
    }

    if ($cont > 0){
        echo "<script> window.alert('Produto já cadastrado!'); </script>";
    }
    else{

        # CORRIGIR: a página trava quando coloca o b64 da imagem

        $query = "INSERT INTO produtos(pd_nome, pd_desc, pd_quant, pd_valor, pd_img, pd_ativo) VALUES('$nome', '$descricao', '$quantidade', '$valor', '$imagem', 'n')";
        mysqli_query($link, $query);
        echo "<script> window.alert('Produto cadastrado com sucesso!'); </script>";
        echo "<script> window.location.href='Cadastro Produto.php'; </script>";
    }
}

?>

<html>
    <head>
        <link rel="stylesheet" href="./Css/Cadastro.css">
        <title> Cadastro de produto </title>
    </head>
    <body>
        <div>
            <form action="Cadastro Produto.php" method="post">
                <h1>Cadastro de produto</h1>
                <p>Nome</p>
                <input type="text" name="nome" id="nome" placeholder="Nome do produto">
                <p>Descrição</p>
                <input type="text" name="descricao" id="descricao" placeholder="Descrição">
                <p>Quantidade</p>
                <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade">
                <p>Valor (R$)</p>
                <input type="number" step="0.01" name="valor" id="valor" placeholder="Valor">
                <p>Imagem</p>
                <input type="file" name="imagem" id="imagem" placeholder="Imagem">
                <p></p>
                <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
                <p></p>
            </form>
        </div>
    </body>
</html>