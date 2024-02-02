<?php 

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $vendaId = $_GET['vendaid'];
    $estado = $_GET['estado'];

    // Muda o estado da encomenda
    $sql = "UPDATE encomendas SET enc_status = '$estado' WHERE fk_ven_id = $vendaId";

    try {
        mysqli_query($link, $sql);

        echo "1";
    }
    catch (Exception $e) {
        echo "0";
    }
}

?>