<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
    <link rel="stylesheet" href="./Css/Visão Adm.css">
</head>

<body>
    <?php

    include("Cabecalho.php");

    ?>

    <div style="width: 100%; height:10px; background-color:transparent;">
        <?php
        
        $query = "SELECT * FROM produtos WHERE pd_ativo = 's'";
        $result = mysqli_query($link, $query);

        while($tbl = mysqli_fetch_array($result)){

        ?>
        <div class="product-card">
            <img src="data:image/jpeg;base64,<?=$tbl[6]?>" alt="Imagem do produto">
            <h3 class="product-title"><?=$tbl[1]?></h3>
            <h3 class="product-price"><?=$tbl[4]?></h3>
            
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