<?php

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $custo = $_POST['custo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $validade = $_POST['validade'];
    $fornecedor_id = $_POST['fornecedor'];

    $sql = "SELECT COUNT(pro_id) FROM produtos WHERE pro_nome = '$nome'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($cont == 0){
        $sql = "INSERT INTO produtos(pro_nome, pro_descricao, pro_custo, pro_preco, pro_quantidade, pro_validade, pro_status, fk_fornecedor_id) VALUES('$nome','$descricao',$custo,$preco,$quantidade,'$validade','s', $fornecedor_id)";
        mysqli_query($link, $sql);
        echo "1";
    }
    else{
        echo "0";
    }
}

?>