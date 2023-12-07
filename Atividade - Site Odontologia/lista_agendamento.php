<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Agendamentos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include("cabecalho.php"); ?>

    <h2 style="display: block; margin-top:20px; margin-bottom:40px; text-align:center; color:white; text-shadow: 2px 2px 5px black;">Agendamentos</h2>

    <div class="table-container" style="max-width: 850px;">
        <table>
            <th>Nome Paciente</th>
            <th>Nome Dentista</th>
            <th>Dia e Hora</th>
            <th>Detalhes</th>
            <?php
                        
                $sql = "SELECT a.ID, p.NOME, d.NOME, a.DIA_HORA 
                FROM agendamentos a 
                INNER JOIN pacientes p ON a.FK_PACIENTE_ID = p.ID
                INNER JOIN dentistas d ON a.FK_DENTISTA_ID = d.ID";

                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[1] ?></td>
                        <td><?= $tbl[2] ?></td>
                        <td><?= $tbl[3] ?></td>
                        <td><a href="detalhes_dentista.php?id=<?=$tbl[0]?>">Ver detalhes</a></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>
</html>