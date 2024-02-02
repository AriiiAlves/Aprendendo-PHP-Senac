<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $fornecedor_id = $_POST['fornecedor_id'];
    $fornecedor_nome = $_POST['fornecedor_nome'];

    // Edita os dados do fornecedor
    $sql = "UPDATE fornecedores SET fornecedor_nome = '$fornecedor_nome' WHERE fornecedor_id = $fornecedor_id";
    mysqli_query($link, $sql);
    echo "1";
}

?>