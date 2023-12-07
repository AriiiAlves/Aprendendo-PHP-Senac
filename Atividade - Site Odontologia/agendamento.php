<?php

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cpf_paciente = $_POST['cpf1'];
    $cpf_paciente = str_replace('.', '', $cpf_paciente);
    $cpf_paciente = str_replace('-', '', $cpf_paciente);

    $cpf_dentista = $_POST['cpf2'];
    $cpf_dentista = str_replace('.', '', $cpf_dentista);
    $cpf_dentista = str_replace('-', '', $cpf_dentista);

    $dia_hora = $_POST['dia_hora'];

    $sql = "SELECT COUNT(CPF) FROM pacientes WHERE CPF = '$cpf_paciente'";
    $cont2 = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    $sql = "SELECT COUNT(CPF) FROM dentistas WHERE CPF = '$cpf_dentista'";
    $cont1 = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($cont1 != 0 && $cont2 != 0){
        $sql = "SELECT ID FROM pacientes WHERE CPF = '$cpf_paciente'";
        $id_paciente = mysqli_fetch_array(mysqli_query($link, $sql))[0];

        $sql = "SELECT ID FROM dentistas WHERE CPF = '$cpf_dentista'";
        $id_dentista = mysqli_fetch_array(mysqli_query($link, $sql))[0];

        $sql = "INSERT INTO agendamentos(FK_PACIENTE_ID, FK_DENTISTA_ID, DIA_HORA) 
        VALUES($id_paciente,$id_dentista,'$dia_hora')";
        mysqli_query($link, $sql);

        echo "<script>window.alert('Agendamento realizado com sucesso!'); window.location.hreft='agendamento.php';</script>";
    }
    else{
        echo "<script>window.alert('Dados incorretos!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include("cabecalho.php"); ?>
    <div class="container">
        <h2 class="titulo">Agendar</h2>
        <form action="agendamento.php" method="post">
            <label for="cpf">CPF (Paciente)</label> 
            <input type="text" minlength="14" name="cpf1" id="cpf1" required><br>
            <br>
            <label for="cpf">CPF (Dentista)</label>
            <input type="text" minlength="14" name="cpf2" id="cpf2" required><br>
            <br>
            <label for="data">Data da consulta</label>
            <input type="datetime-local" name="dia_hora" id="dia_hora" required><br>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function() {
    $('#cpf1').mask('000.000.000-00'); // Define a máscara para cpf
  });
  $(document).ready(function() {
    $('#cpf2').mask('000.000.000-00'); // Define a máscara para cpf
  });
</script>
