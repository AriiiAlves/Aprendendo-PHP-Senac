<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $senha = $_POST['senha'];
    $nova_senha = $_POST['nova_senha'];

    session_start();
    $cli_id = $_SESSION['idusuario'];

    $sql = "SELECT cli_senha FROM clientes WHERE cli_id = $cli_id";
    $senha_db = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($senha === $senha_db){
        $sql = "UPDATE clientes SET cli_senha = '$nova_senha' WHERE cli_id = $cli_id";
        mysqli_query($link, $sql);
        echo "1";
    }
    else{
        echo "0";
    }
}

?>