<?php

include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] === 'POST') {
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