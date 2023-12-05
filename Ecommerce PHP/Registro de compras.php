<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de compras</title>
    <link rel="stylesheet" href="./Css/Visão Adm.css">
</head>

<body>
    <?php

    include("Cabecalho Cliente.php");

    ?>

    <div style="width: 100%; height:10px; background-color:transparent; text-align:center;">
        <?php
        
        $query = "SELECT * FROM carrinho WHERE car_finalizado = 's' ORDER BY car_datavenda DESC";
        $result = mysqli_query($link, $query);

        while($tbl = mysqli_fetch_array($result)){

        ?>
        <div class="product-card" style="height: 200px;">
            <h3 class="product-title"><?=substr($tbl[2], 8, 2)?>/<?=substr($tbl[2], 5, 2)?>/<?=substr($tbl[2], 0, 4)?></h3>
            <h3 class="product-price">Pago: R$ <?=number_format($tbl[1], 2, ',', '.')?></h3>
            <button onclick="location.href='Detalhes Carrinho.php?id=<?=$tbl[0]?>'" class="product-button">Detalhes</button>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>