<?php

session_start();
include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $data_entrega = $_GET['q'];

    // Registrar encomenda
    try {
        if(isset($_SESSION['codigo_venda'])) {
            $codigo_venda = $_SESSION['codigo_venda'];
            $sql = "SELECT COUNT(iv_id) FROM item_venda WHERE iv_codigo =" . $codigo_venda;
            $retorno = mysqli_fetch_array(mysqli_query($link, $sql))[0];
    
            if($retorno > 0) {
                // Gerando as variáveis da venda
                $sql = "SELECT SUM(iv_total) FROM item_venda WHERE" . $codigo_venda;
                
                $total_compra = mysqli_fetch_array(mysqli_query($link, $sql))[0];
                $cli_id = $_SESSION['idusuario'];

                // Primeiro gera a venda
                $sql = "INSERT INTO vendas(ven_data, fk_cli_id, fk_iv_codigo, ven_total)
                    VALUES(
                        NOW(), $cli_id, $codigo_venda, $total_compra
                    )";
                    mysqli_query($link, $sql);

                // Depois gera a encomenda
                $sql = "SELECT iv_id, iv_quantidade FROM item_venda WHERE iv_codigo = " . $codigo_venda;
                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)) {
                    $pro_id = $tbl[0];
                    $pro_quantidade = $tbl[1];

                    $sql = "INSERT INTO encomendas(enc_emissao, enc_entrega, fk_pro_id, enc_pro_quantidade, fk_cli_id, fk_ven_id, enc_status)
                    VALUES(
                        NOW(),
                        $data_entrega,
                        $pro_id,
                        $pro_quantidade,
                        $cli_id,
                        $codigo_venda,
                        's'
                    )";
                    mysqli_query($link, $sql);
                }

                unset($_SESSION['codigo_venda']);
                echo("1");
            } 
            else {
                echo('void_cart');
            }
        }
        else {
            echo('void_cart');
        }
    }
    catch (Exception $e) {
        echo($e);
    }
}