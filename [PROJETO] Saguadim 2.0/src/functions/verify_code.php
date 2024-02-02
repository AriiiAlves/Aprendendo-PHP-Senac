<?php 

include('conectadb.php');

// Código incompleto, devido à falha no PHPMail, que envia o código

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];

    // Verificando se o código confere com o usuário (há uma falha aqui de verificação, o email tem que ser verificado também)
    // Caso vá usar essa parte de código, reescrevê-la depois
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