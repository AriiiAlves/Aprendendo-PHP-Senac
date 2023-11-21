<?php

include("Cabecalho Cliente.php");

$idusuario = $_SESSION['idusuario'];

// Pesquisa identificador do carrinho
$sql = "SELECT
c.car_id, c.fk_cli_id, c.car_finalizado,
p.pd_id, p.pd_nome, p.pd_desc, p.pd_valor, p.pd_img,
ic.car_item_quantidade, ic.fk_car_id, ic.fk_pro_id
FROM carrinho c
JOIN item_carrinho ic ON c.car_id = ic.fk_car_id
JOIN produtos p ON ic.fk_pro_id = p.pd_id
WHERE c.fk_cli_id = $idusuario
AND c.car_finalizado = 'n'";
$retorno = mysqli_query($link, $sql);
$retorno2 = mysqli_query($link, $sql); # usado para fazer o total

$total = 0; // Inicializa a variável total

while ($row = mysqli_fetch_assoc($retorno2)){
    $preco = $row['pd_valor'];
    $quantidade = $row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal; // Adiciona o subtotal ao total
}

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
    <br>
        <div class="total" style="position:relative; left:40%; width:20%; height:30px; background-color:white; border-radius:8px; text-align:center; padding-top:10px;"><a>Total R$ <?= $total ?></a></div>
        <br>
        <div class="total" style="position:relative; left:44.5%; width:150px; height:30px; background-color:white; border-radius:8px; text-align:center; padding-top:10px;">
            <a href="Finaliza Carrinho.php?id=<?= $idusuario ?>">Finaliza carrinho</a>
        </div>

    <!--div acima apenas para separar o menu-->
    <?php
    
    while ($tbl = mysqli_fetch_array($retorno)){
    
    ?>
        <div class="product-card">
            <img src="data:image/jpeg;base64, <?= $tbl[7] ?>">
            <h3 class="product-title"> <?= $tbl[4] ?> </h3>
            <h3 class="product-price"> R$ <?= $tbl[6] * $tbl[8] ?> </h3>
            <label>Quantidade</label>
            <div>
                <h3 class="product-price plus-button"><?=$tbl[8]?></h3>
                <button onclick="location.href='Atualiza Carrinho.php?var1=<?= $tbl[3]?>&var2=<?=$tbl[8] - 1?>'" class="plus-button">-</button>
                <button onclick="location.href='Atualiza Carrinho.php?var1=<?=$tbl[3]?>&var2=<?=$tbl[8] + 1?>'" class="plus-button">+</button>
            </div>
            <br>
            <div>
                <button onclick="location.href='Deleta Produto Carrinho.php?var1=<?=$tbl[3]?>&var2=<?=$tbl[0]?>'" class="plus-button">Excluir do Carrinho</button>
            </div>
        </div>
    
    <?php
    }
    ?>
</body>
</html>