<?php

include("Cabecalho Cliente.php");

$idusuario = $_SESSION['idusuario'];

# Pesquisa identificador do carrinho
$sql = "SELECT
c.car_id, c.fk_cli_id, c.car_finalizado,
p.pd_id, p.pd_nome, p.pd_desc, p.pd_valor, p.pd_img,
ic.car_item_quantidade, ic.fk_car_id, ic.fk_pro_id
FROM carrinho c
JOIN item_carrinho ic ON c.car_id = ic.fk_car_id
JOIN produtos p ON ic.fk_pro_id = p.pro_id
WHERE c.fk_cli_id = $idusuario
AND c.car_finalizado = 'n'";
$retorno = mysqli_query($link, $sql);
$retorno2 = mysqli_query($link, $sql); # usado para fazer o total

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
    <div style="width:100%; height:10px; background-color:transparent;"></div>
    <div class="total" style="width:100%; height:30px;">Total R$ <?= $total ?></div>
    <div class="total" style="width: 100%; height:30px;">
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
                <button onclick="location.href='Atualizar Carrinho.php?var1=<?= $tbl[3]?>$var2=<?=$tbl[8] - 1?>'" class="plus-button">-</button>
                <h3 class="product-price plus-button"><?=$tbl[8]?></h3>
                <button onclick="location.href='Atualizar Carrinho.php?var1=<?=$tbl[3]?>$var2=<?=$tbl[8] + 1?>'" class="plus-button">+</button>
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