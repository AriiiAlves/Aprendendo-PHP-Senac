<?php
include("cabecalho.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $custo = $_POST['custo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $validade = $_POST['validade'];
    $fornecedor_id = $_POST['fornecedor'];

    $sql = "SELECT COUNT(pro_id) FROM produtos WHERE pro_nome = '$nome'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($cont == 0){
        $sql = "INSERT INTO produtos(pro_nome, pro_descricao, pro_custo, pro_preco, pro_quantidade, pro_validade, pro_status, fk_fornecedor_id) VALUES('$nome','$descricao',$custo,$preco,$quantidade,'$validade','s', $fornecedor_id)";
        mysqli_query($link, $sql);
        echo "<script>window.alert('Produto cadastrado com sucesso!'); window.location.hreft='listaproduto.php';</script>";
    }
    else{
        echo "<script>window.alert('Produto já existente!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="cadastraproduto.css">
</head>
<body>
    <div class="container">
        <h2 class="titulo">Cadastro de Produto</h2>
        <form action="cadastraproduto.php" method="post">
            <label for="nomeproduto">Nome</label>
            <input type="text" name="nome" id="nomeproduto" required><br>
            <label for="descricao">Descrição</label>
            <textarea name="descricao" rows="5" id="descricao" required></textarea><br>
            <label for="custo">Custo</label>
            <input type="number" name="custo" step="0.01" id="custo" required><br>
            <label for="preco">Preço</label>
            <input type="number" name="preco" step="0.01" id="preco" required><br>
            <label for="quantidade">Quantidade</label>
            <input type="number" name="quantidade" min="0" id="quantidade" required><br>
            <label for="validade">Validade</label>
            <input type="date" name="validade" id="validade" required><br>
            <label for="select">Fornecedor</label>
            <select name="fornecedor" id="fornecedor" required>
                <?php
                
                    $sql = "SELECT fornecedor_id, fornecedor_nome FROM fornecedores";
                    $retorno = mysqli_query($link, $sql);

                    while($tbl = mysqli_fetch_array($retorno)){
                ?>
                        <option value="<?=$tbl[0]?>"><?=$tbl[1]?></option>
                <?php
                    }
                ?>
            </select><br>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>