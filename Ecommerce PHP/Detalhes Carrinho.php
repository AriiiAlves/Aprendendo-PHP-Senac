<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/Visão Adm.css">
    <title>Carrinho</title>
</head>
<body>
    <?php
    
    include("Cabecalho Cliente.php");
    $car_id = $_GET['id'];

    $query = "SELECT car_valorvenda, car_datavenda FROM carrinho WHERE car_id = $car_id";
    $total = mysqli_fetch_array(mysqli_query($link, $query))[0];
    $data = mysqli_fetch_array(mysqli_query($link, $query))[1];
    
    ?>
    <div>
        <h3 style="text-align:center; margin-top:20px;"><p>Pedido <?=substr($data, 8, 2)?>/<?=substr($data, 5, 2)?>/<?=substr($data, 0, 4)?></p></h3>
        <h3 style="text-align:center; margin-top:20px;"><p>Total:  <?=$total?></p></h3>
    </div>
    <br>
    <div style="width: 100%; height:10px; background-color:transparent; text-align:center;">
        <?php
            $query = "SELECT fk_pro_id, car_item_quantidade FROM item_carrinho WHERE fk_car_id = $car_id";
            $result = mysqli_query($link, $query);

            while($tbl = mysqli_fetch_array($result)){
                $query = "SELECT * FROM produtos WHERE pd_id = $tbl[0]";
                $result2 = mysqli_query($link, $query);

                while($tbl2 = mysqli_fetch_array($result2)){
                    ?>
                <div class="product-card" style="height: 350px;">
                    <img src="data:image/jpeg;base64,<?=$tbl2[6]?>" alt="Imagem do produto">
                    <h3 class="product-title"><?=$tbl2[1]?> (<?=$tbl[1]?>)</h3>
                    <h3 class="product-price">R$ <?=number_format(($tbl2[4] * $tbl[1]), 2, ',', '.')?></h3>
                    
                </div>
                <?php
                }
            }
            ?>
    </div>
</body>
</html>