<?php

include("cabecalho.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['fornecedor'];

    $sql = "SELECT COUNT(fornecedor_id) FROM fornecedores WHERE fornecedor_nome = '$nome'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($cont == 0){
        $sql = "INSERT INTO fornecedores (fornecedor_nome) VALUES('$nome')";
        mysqli_query($link, $sql);

        echo "<script>window.alert('Fornecedor cadastrado com sucesso!'); window.location.hreft='cadastrafornecedor.php';</script>";
    }
    else{
        echo "<script>window.alert('Fornecedor já existente!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Fornecedor</title>
    <link rel="stylesheet" href="cadastraproduto.css">
</head>
<body>
    <div class="container">
        <h2 class="titulo">Cadastro de Fornecedor</h2>
        <form action="cadastrafornecedor.php" method="post">
            <label for="fornecedor">Nome do Fornecedor</label>
            <input type="text" name="fornecedor" id="fornecedor" required><br>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>