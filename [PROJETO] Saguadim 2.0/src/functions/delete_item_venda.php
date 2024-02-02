<?php

include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tenta excluir o item do carrinho/pedido/venda aberta especificado
    // segundo o seu iv_id (id do item na tabela item_venda)
    try {
        $codigo_venda = $_POST['codigo_venda'];

        $sql = "DELETE FROM item_venda WHERE iv_id = $codigo_venda";
        mysqli_query($link, $sql);
        echo('1');
    }
    catch (Exception $e) {
        echo('0');
    }
}

?>