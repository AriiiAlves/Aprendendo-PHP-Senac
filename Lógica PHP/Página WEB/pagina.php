<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    # Se os 2 inputs foram preenchidos, os 2 são declarados com os valores recebidos pelo método POST.
    if (is_numeric($_POST['numero1']) && is_numeric($_POST['numero2'])){
        $numero1 = $_POST['numero1'];
        $numero2 = $_POST['numero2'];
    }
    # Se o valor vazio é 'numero2', ele é declarado como 0.
    else if (is_numeric($_POST['numero1'])){
        $numero1 = $_POST['numero1'];
        $numero2 = 0;
    }
    # Se o valor vazio é 'numero1', ele é declarado como 0.
    else if (is_numeric($_POST['numero2'])){
        $numero1 = 0;
        $numero2 = $_POST['numero2'];
    }
    # Se os dois valores são vazios, ambos são declarados como 0.
    else{
        $numero1 = 0;
        $numero2 = 0;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- PAGINA PARA FAZER SOMA ENTRE NUMEROS -->
    <form action="pagina.php" method="post">
        <label>DIGITE UM NUMERO</label>
        <input type="number" name="numero1">
        <br>
        <label>DIGITE OUTRO NUMERO</label>
        <input type="number" name="numero2">
        <br>
        <label>O RESULTADO É: <?=$numero1 + $numero2?></label>
        <br>
        <input type="submit" value="SOMAR">
    </form>
</body>
</html>