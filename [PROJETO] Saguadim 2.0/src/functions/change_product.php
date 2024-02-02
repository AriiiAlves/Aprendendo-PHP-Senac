<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $pro_id = $_POST['pro_id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $custo = $_POST['custo'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $validade = $_POST['validade'];
    $fornecedor_id = $_POST['fornecedor_id'];
    $status = $_POST['status'];

    // Edita os dados do produto
    $sql = "UPDATE produtos SET 
        pro_nome = '$nome',
        pro_descricao = '$descricao',
        pro_custo = '$custo',
        pro_preco = '$preco',
        pro_quantidade = '$quantidade',
        pro_validade = '$validade',
        fk_fornecedor_id = '$fornecedor_id',
        pro_status = '$status'

        WHERE pro_id = $pro_id";
    mysqli_query($link, $sql);
    echo "1";
}

?>