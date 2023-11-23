<?php

include("cabecalho.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="cadastraproduto.css">
    <style>
        .table-container {
            max-width: 600px;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <table>
            <th>Login</th>
            <th>Email</th>
            <th>Status</th>
            <?php
                        
                $sql = "SELECT usu_login, usu_email, usu_status FROM usuarios";
                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[0] ?></td>
                        <td><?= $tbl[1] ?></td>
                        <td data-status="<?= $tbl[2] == 's'?"Ativo":"Inativo" ?>"></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>