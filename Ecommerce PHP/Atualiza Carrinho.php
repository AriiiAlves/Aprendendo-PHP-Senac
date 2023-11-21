<?php

include("Conexão com banco.php");

// Coleta dados do GET
$id = $_GET['var1'];
$quantidade = $_GET['var2'];

// Realizando consulta
$sql = "SELECT pd_quant FROM produtos WHERE pd_id = $id";
$quantidade_estoque = mysqli_fetch_array(mysqli_query($link, $sql))[0];

// Atualiza a quantidade do item no banco de dados se a condição for válida
if($quantidade <= $quantidade_estoque and $quantidade > 0){
    $sql = "UPDATE item_carrinho SET car_item_quantidade = $quantidade WHERE fk_pro_id = $id";
    $resultado = mysqli_query($link, $sql);
}

// Retorna para o carrinho
header("Location: Carrinho.php");

?>