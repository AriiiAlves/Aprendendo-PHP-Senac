<?php

include("conectadb.php");

$id_dentista = $_GET['id'];

$sql = "SELECT NOME FROM dentistas WHERE ID = $id_dentista";
$nome = mysqli_fetch_array(mysqli_query($link, $sql))[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include("cabecalho.php"); ?>

    <h2 style="display: block; margin-top:20px; margin-bottom:40px; text-align:center; color:white; text-shadow: 2px 2px 5px black;">Ficha profissional genérica de <span style="color:tomato"><?=$nome?></span></h2>

    <div class="table-container">
        <table>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>Email</th>
            <th>Celular</th>
            <th>Data de Nascimento</th>
            <th>CRO</th>
            <?php
                        
                $sql = "SELECT * FROM dentistas WHERE ID = $id_dentista";

                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[1] ?></td>
                        <td><?= $tbl[2] ?></td>
                        <td><?= $tbl[3] ?></td>
                        <td><?= $tbl[4] ?></td>
                        <td><?= $tbl[5] ?></td>
                        <td><?= $tbl[6] ?></td>
                        <td><?= $tbl[7] ?></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div class="table-container">
        <table>
            <th>Rua</th>
            <th>Número</th>
            <th>Bairro</th>
            <th>CEP</th>
            <th>Cidade</th>
            <th>Estado</th>
            <?php
                        
                $sql = "SELECT * FROM endereco_dentistas
                WHERE FK_DENTISTA_ID = $id_dentista";

                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[1] ?></td>
                        <td><?= $tbl[2] ?></td>
                        <td><?= $tbl[3] ?></td>
                        <td><?= $tbl[4] ?></td>
                        <td><?= $tbl[5] ?></td>
                        <td><?= $tbl[6] ?></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>