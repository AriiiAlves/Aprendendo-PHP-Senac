<?php

include("Cabecalho Cliente.php");

# Recebe o produto que o usuário quer favoritar
$id = $_GET['id'];

# Verifica se o usuário está logado
if (isset($idusuario)){
    # Verifica se já está favoritado, caso já esteja, remove o favorito
    $sql = "SELECT COUNT(fav_id) FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if($cont == 0){
        $sql = "INSERT INTO favoritos (fav_cli_id, fav_pro_id) VALUES ($idusuario, $id)";
        mysqli_query($link, $sql);
    }
    else{
        $sql = "DELETE FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
        mysqli_query($link, $sql);
    }
}
else{
    echo "<script>window.alert('Faça login para favoritar!');</script>";
    header("Location: Login Cliente.php");
}
header("Location: Ver Produto.php?id=$id");
exit;

?>