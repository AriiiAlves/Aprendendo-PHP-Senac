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

// Usado par afazer a remoção dos itens do inventário
$retorno1 = mysqli_query($link, $sql);

// Usado para fazer o total
$retorno2 = mysqli_query($link, $sql);

// Usado par afazer a finalização do carrinho
$retorno3 = mysqli_query($link, $sql);

$total = 0; // Inicializa a variável total

while ($row = mysqli_fetch_assoc($retorno2)){
    $preco = $row['pd_valor'];
    $quantidade = $row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal; // Adiciona o subtotal ao total
}

// Tira os itens do inventário
while ($tbl = mysqli_fetch_array($retorno1)){
    $sql = "SELECT pd_quant FROM produtos WHERE pd_id = $tbl[3]";

    $retorno4 = mysqli_query($link, $sql); 

    while ($row = mysqli_fetch_assoc($retorno4)){
        $quantidade_produto = $row['pd_quant'];
        $sql = "UPDATE produtos SET pd_quant = $quantidade_produto - $tbl[8] WHERE pd_id = $tbl[3]";
        $resultado4 = mysqli_query($link, $sql);
    }
}

$tbl = mysqli_fetch_array($retorno3);

// Inclui o total, data da venda e finaliza o carrinho
$data = date("Y-m-d"); // Dia atual

// Consultando o total de itens que há no carrinho
$sql = "SELECT COUNT(*) FROM item_carrinho WHERE fk_car_id = $tbl[0]";
$retorno3 = mysqli_query($link, $sql);
$total_itens = mysqli_fetch_array($retorno3);

// Realizando o update
$sql_total = "UPDATE carrinho SET car_valorvenda = $total, car_datavenda = '$data', car_finalizado = 's', car_total_item = $total_itens[0] WHERE car_id = $tbl[0]";
$resultado2 = mysqli_query($link, $sql_total);

header("Location: Loja.php");

?>