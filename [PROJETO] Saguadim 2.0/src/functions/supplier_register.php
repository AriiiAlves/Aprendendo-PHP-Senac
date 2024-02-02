<?php
include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];

    # Inserir instruções no banco
    $sql = "SELECT COUNT(fornecedor_id) FROM fornecedores WHERE fornecedor_nome = '$nome'";
    $resultado = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($resultado)[0];

    # Grava Log
    $sql = '"' . $sql . '"';
    $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
        VALUES ($sql, NOW())";
    mysqli_query($link, $sqllog);

    # Verifica se o fornecedor já existe
    if($resultado >= 1){
        echo "0";
    }
    else{
        // Caso não exista, cria o novo fornecedor
        $sql = "INSERT INTO fornecedores(fornecedor_nome) VALUES('$nome')";
        mysqli_query($link, $sql);

        echo "1";
    }
}

exit();

?>