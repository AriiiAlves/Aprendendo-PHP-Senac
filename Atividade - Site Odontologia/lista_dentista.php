<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Dentistas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include("cabecalho.php"); ?>

    <h2 style="display: block; margin-top:20px; margin-bottom:40px; text-align:center; color:white; text-shadow: 2px 2px 5px black;">Dentistas</h2>

    <div class="table-container" style="max-width: 850px;">
        <table>
            <th>Nome</th>
            <th>CPF</th>
            <th>CRO</th>
            <th>Detalhes</th>
            <?php
                        
                $sql = "SELECT d.ID, d.NOME, d.CPF, d.CRO, d.RG, d.EMAIL,d.CELULAR, d.DATA_NASC, e.RUA, e.NUMERO, e.BAIRRO, e.CEP, e.CIDADE, e.ESTADO 
                FROM endereco_dentistas e 
                INNER JOIN dentistas d 
                ON d.ID = e.FK_DENTISTA_ID
                WHERE 1=1";

                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[1] ?></td>
                        <td><?= $tbl[2] ?></td>
                        <td><?= $tbl[3] ?></td>
                        <td><a href="ficha_dentista.php?id=<?=$tbl[0]?>">Ver Ficha</a></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>