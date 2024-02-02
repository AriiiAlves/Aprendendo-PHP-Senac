<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Se a variável via post for cli_id, exclui o cliente especificado
    if(!empty($_POST['cli_id'])) {
        $cli_id = $_POST['cli_id'];
        $sql = "DELETE FROM clientes WHERE cli_id = $cli_id";
        mysqli_query($link, $sql);
        echo "1";
    }
    // Se a variável via post for usu_id, exclui o usuário especificado
    else if(!empty($_POST['usu_id'])) {
        $usu_id = $_POST['usu_id'];
        $sql = "DELETE FROM usuarios WHERE usu_id = $usu_id";
        mysqli_query($link, $sql);
        echo "1";
    }
    // Se a variável via post for fornecedor_id, exclui o fornecedor especificado
    else if(!empty($_POST['fornecedor_id'])) {
        $fornecedor_id = $_POST['fornecedor_id'];
        $sql = "DELETE FROM fornecedores WHERE fornecedor_id = $fornecedor_id";
        mysqli_query($link, $sql);
        echo "1";
    }
    // Se a variável via post for pro_id, exclui o produto especificado
    else if(!empty($_POST['pro_id'])) {
        $pro_id = $_POST['pro_id'];
        $sql = "DELETE FROM produtos WHERE pro_id = $pro_id";
        mysqli_query($link, $sql);
        echo "1";
    }
    // Se não for nenhum caso, retorna um erro
    else {
        echo "0";
    }
}

?>