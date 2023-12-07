<?php

include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);

    $rg = $_POST['rg'];
    $rg = str_replace('.', '', $rg);
    $rg = str_replace('-', '', $rg);

    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $celular = str_replace('(', '', $celular);
    $celular = str_replace(')', '', $celular);
    $celular = str_replace('-', '', $celular);
    $celular = str_replace(' ', '', $celular);

    $data_nasc = $_POST['data_nasc'];
    $convenio = $_POST['convenio'];

    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $cep = str_replace('-', '', $cep);

    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "SELECT COUNT(CPF) FROM pacientes WHERE CPF = '$cpf'";
    $cont = mysqli_fetch_array(mysqli_query($link, $sql))[0];

    if ($cont == 0){
        $sql = "INSERT INTO pacientes(NOME, CPF, RG, EMAIL, CELULAR, DATA_NASC, CONVENIO) VALUES('$nome','$cpf','$rg','$email','$celular','$data_nasc','$convenio')";
        mysqli_query($link, $sql);
        
        $sql = "SELECT ID FROM pacientes WHERE CPF = '$cpf'";
        $id = mysqli_fetch_array(mysqli_query($link, $sql))[0];

        $sql = "INSERT INTO endereco_pacientes(FK_PACIENTE_ID, RUA, NUMERO, BAIRRO, CEP, CIDADE, ESTADO) 
        VALUES($id,'$rua','$numero','$bairro','$cep','$cidade','$estado')";
        mysqli_query($link, $sql);

        echo "<script>window.alert('Paciente cadastrado com sucesso!'); window.location.hreft='cadastra_paciente.php';</script>";
    }
    else{
        echo "<script>window.alert('Paciente já cadastrado!');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include("cabecalho.php"); ?>
    <div class="container">
        <h2 class="titulo">Cadastro de Paciente</h2>
        <form action="cadastra_paciente.php" method="post">
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required><br>
            <label for="cpf">CPF</label>
            <input type="text" minlength="14" maxlength="14" name="cpf" id="cpf" required><br>
            <label for="rg">RG</label>
            <input type="text" minlength="13" maxlength="13" name="rg" id="rg" required><br>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required><br>
            <label for="celular">Celular</label>
            <input type="text" minlength="11" maxlength="11" name="celular" id="celular" required><br>
            <label for="data_nasc">Data de Nascimento</label>
            <input type="date" name="data_nasc" id="data_nasc" required><br>
            <label for="convenio">Convênio</label>
            <input type="text" name="convenio" id="convenio" required><br>

            <label for="nome">Rua</label>
            <input type="text" name="rua" id="rua" required><br>
            <label for="nome">Número</label>
            <input type="text" name="numero" id="numero" required><br>
            <label for="nome">Bairro</label>
            <input type="text" name="bairro" id="bairro" required><br>
            <label for="nome">CEP</label>
            <input type="text" minlength="9" name="cep" id="cep" required><br>
            <label for="nome">Cidade</label>
            <input type="text" name="cidade" id="cidade" required><br>
            <label for="nome">Estado</label>
            <input type="text" name="estado" id="estado" required><br>

            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function() {
    $('#celular').mask('(00) 00000-0000'); // Define a máscara para celular
  });
  $(document).ready(function() {
    $('#cpf').mask('000.000.000-00'); // Define a máscara para cpf
  });
  $(document).ready(function() {
    $('#rg').mask('00.000.000-00'); // Define a máscara para rg
  });
  $(document).ready(function() {
    $('#cep').mask('00000-000'); // Define a máscara para cep
  });
</script>

