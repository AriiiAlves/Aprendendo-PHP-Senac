<?php

include("Cabecalho Cliente.php");

$idcliente = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE cli_id = $idcliente";
$retorno = mysqli_fetch_array(mysqli_query($link, $sql));

$cpf = "$retorno[1]";
$cpf = substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);

$nome = $retorno[2];
$datanasc = $retorno[4];

$telefone = "$retorno[5]";
if(strlen($telefone) == 10){
    $telefone = "(" . substr($telefone, 0, 2) . ") " . substr($telefone, 2, 5) . "-" . substr($telefone, 7, 4);
}
else{
    $telefone = "(" . substr($telefone, 0, 2) . ") " . substr($telefone, 2, 3) . "-" . substr($telefone, 6, 4);
}


$logradouro = $retorno[6];
$numero = $retorno[7];
$cidade = $retorno[8];
$email = $retorno[11];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Visão Adm.css">
    <title>Carrinho</title>
</head>
<body>
    <div style="display: flex; flex-wrap:wrap; width:100%; height:80vh; justify-content:center; align-items:center">
        <div style="width: 400px;">
            <form class="visualizaproduto" style="margin:0;width:auto" action="Ver Produto.php" method="post" enctype="multipart/form-data">
                <label>CPF</label>
                <input type="text" value="<?= $cpf ?>" readonly>
                <label>Nome</label>
                <input type="text" value="<?= $nome ?>" readonly>
                <label>Data de nascimento</label>
                <input type="date" value="<?= $datanasc ?>" readonly>
                <label>Telefone</label>
                <input type="text" value="<?= $telefone ?>" readonly>
                <label>Logradouro</label>
                <input type="text" value="<?= $logradouro ?>" readonly>
                <label>Número</label>
                <input type="text" value="<?= $numero ?>" readonly>
                <label>Cidade</label>
                <input type="text" value="<?= $cidade ?>" readonly>
                <label>Email</label>
                <input type="text" value="<?= $email ?>" readonly>
            </form>      
        </div>
    </div>
    <br>
    <div>
        <h3 style="text-align:center; margin-top:20px;"><p>Favoritos</p></h3>
    </div>
    <br>
    <div style="width: 100%; height:10px; background-color:transparent; text-align:center;">
        <?php

            $query = "SELECT p.*, f.fav_pro_id FROM favoritos f JOIN produtos p ON f.fav_pro_id = p.pd_id WHERE f.fav_cli_id = $idcliente";
            $result = mysqli_query($link, $query);

            while($tbl = mysqli_fetch_array($result)){

                ?>
                <div class="product-card">
                    <img src="data:image/jpeg;base64,<?=$tbl[6]?>" alt="Imagem do produto">
                    <h3 class="product-title"><?=$tbl[1]?></h3>
                    <h3 class="product-price">R$ <?=number_format($tbl[4], 2, ',', '.')?></h3>
                    
                    <?php
                    if ($tbl[3] > 0){
                    ?>
        
                    <button onclick="location.href='Ver Produto.php?id=<?=$tbl[0]?>'" class="product-button">Comprar</button>
                    
                    <?php
                    } else{
                    ?>
        
                    <button class="product-button2">Fora de estoque</button> 
                    
                    <?php
                    }
                    ?>
                </div>
                <?php
                }
                ?>
            </div>
</body>
</html>