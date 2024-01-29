<?php 

include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];

    $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_key = '$codigo'";
    $resultado = mysqli_query($link, $sql);
    $resultado = mysqli_fetch_array($resultado)[0];

    if($resultado >= 1){
        echo "1";
    }
    else {
        echo "0";
    }
}

?>