<?php

session_start();
include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {
        $pro_id = $_POST['pro_id'];
        $quantidade = $_POST['quantidade'];
    
        $sql = 'SELECT pro_preco FROM produtos WHERE pro_id =' . $pro_id;
        $preco = mysqli_fetch_array(mysqli_query($link, $sql))[0];
        $total = $preco * $quantidade;
        
        if(empty($_SESSION['venda_id'])) {
            $venda_id = rand(1, 9999999);
            $sql = 'SELECT COUNT(iv_id) FROM item_venda WHERE iv_codigo = ' . $venda_id;
            $retorno = mysqli_fetch_array(mysqli_query($link, $sql))[0];
    
            while($retorno > 0) {
                $venda_id = rand(1, 9999999);
                $sql = 'SELECT COUNT(iv_id) FROM item_venda WHERE iv_codigo = ' . $venda_id;
                $retorno = mysqli_fetch_array(mysqli_query($link, $sql))[0];
            }
    
            $_SESSION['venda_id'] = $venda_id;
        }
        else {
            $venda_id = $_SESSION['venda_id'];
        }
    
        $sql = 'INSERT INTO item_venda(iv_quantidade, iv_total, iv_codigo, fk_pro_id)
                VALUES(' . $quantidade . ',' . $total . ',' . $venda_id . ',' . $pro_id . ')';
        mysqli_query($link, $sql);

        echo('1');
    }
    catch(Exception $e) {
        echo('0');
    }
    exit();
}

?>