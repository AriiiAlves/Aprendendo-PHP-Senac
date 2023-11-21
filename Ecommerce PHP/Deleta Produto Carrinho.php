<?php

include("Conexão com banco.php");
$idprod = $_GET['var1'];
$id = $_GET['var2'];
$sql = "DELETE FROM item_carrinho WHERE fk_pro_id = $idprod AND fk_car_id = $id";
$resultado = mysqli_query($link, $sql);

# Retorna para o carrinho
header("Location: carrinho.php?id=$idusuario");
?>