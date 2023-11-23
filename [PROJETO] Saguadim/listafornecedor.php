<?php

include("cabecalho.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Fornecedores</title>
    <link rel="stylesheet" href="cadastraproduto.css">
    <style>
        .table-container {
            max-width: 500px;
        }
        td:last-child::before {
            content: none;
            display: none;
            padding: 0;
            border-radius: 0;
            color: unset;
            text-transform: none;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <table>
            <th>Nome</th>
            <?php
                        
                $sql = "SELECT fornecedor_nome FROM fornecedores";
                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[0] ?></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>