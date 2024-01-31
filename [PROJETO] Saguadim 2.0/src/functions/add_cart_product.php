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
        
        if(empty($_SESSION['codigo_venda'])) {
            $codigo_venda = rand(1, 9999999);
            $sql = 'SELECT COUNT(iv_id) FROM item_venda WHERE iv_codigo = ' . $codigo_venda;
            $retorno = mysqli_fetch_array(mysqli_query($link, $sql))[0];
    
            while($retorno > 0) {
                $codigo_venda = rand(1, 9999999);
                $sql = 'SELECT COUNT(iv_id) FROM item_venda WHERE iv_codigo = ' . $codigo_venda;
                $retorno = mysqli_fetch_array(mysqli_query($link, $sql))[0];
            }
    
            $_SESSION['codigo_venda'] = $codigo_venda;
        }
        else {
            $codigo_venda = $_SESSION['codigo_venda'];
        }
    
        $sql = 'INSERT INTO item_venda(iv_quantidade, iv_total, iv_codigo, fk_pro_id)
                VALUES(' . $quantidade . ',' . $total . ',' . $codigo_venda . ',' . $pro_id . ')';
        mysqli_query($link, $sql);

        echo('1');

        // Tentativa de enviar uma tabela pronta que atualiza sem recarregar a página por AJAX falhou
        // (não consegui converter string para HTML DOM e inserir no HTML)

        // echo '<th>Nome do produto</th>';
        // echo '<th>Quantidade</th>';
        // echo '<th>Preço unitário (R$)</th>';
        // echo '<th>Preço total (R$)</th>';
        // echo '<th></th>';

        // $sql = "SELECT iv_id, iv_quantidade, iv_total, pro_nome, pro_preco FROM item_venda 
        //         INNER JOIN produtos ON item_venda.fk_pro_id = produtos.pro_id
        //         WHERE iv_codigo =" . $_SESSION['venda_id'];
        // $retorno = mysqli_query($link, $sql);

        // $total_encomenda = 0;
        // $quantidade_encomenda = 0;

        // while($tbl = mysqli_fetch_array($retorno)) {
        //     $iv_id = $tbl[0];
        //     $quantidade = $tbl[1];
        //     $quantidade_encomenda += $quantidade;
        //     $total = $tbl[2];
        //     $total_encomenda += $total;
        //     $nome = $tbl[3];
        //     $preco = $tbl[4];

        //     echo('<tr>');
        //     echo('<td>' . $nome.'</td>');
        //     echo('<td>'  .$quantidade.'</td>');
        //     echo('<td>' . number_format($preco, 2, ',', '') . '</td>');
        //     echo('<td>' . number_format($total, 2, ',', '') . '</td>');
        //     echo('<td><button onclick="deleteItem(' . $iv_id . ')">Excluir</button></td>');
        //     echo('</tr>');
        // }
        // echo('<tr>');
        // echo('<td>Total</td>');
        // echo('<td>' . $quantidade_encomenda . '</td>');
        // echo('<td>-</td>');
        // echo('<td>' . $total_encomenda . '</td>');
        // echo('<td><button>Oculto</button></td>');
        // echo('</tr>');
    }
    catch(Exception $e) {
        echo('0');
    }
    exit();
}

?>