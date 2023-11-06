<?php

# Nav + Variáveis de conexão com banco
include("Cabecalho.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $ativo = $_POST['ativo'];
    $senha = $_POST['senha'];

    // # Busca o tempero
    // $sql = "SELECT usu_tempero FROM usuarios WHERE usu_nome = '$nome'";
    // $retorno = mysqli_query($link, $sql);
    // while ($tbl = mysqli_fetch_array($retorno)){
    //     $tempero = $tbl[0];
    // }

    # Caso a senha tenha sido modificada
    if ($senha != $senha2){
        $senha = md5($senha . $tempero);
    }

    $sql = "UPDATE usuarios SET usu_senha = '$senha', usu_nome = '$nome', usu_ativo = '$ativo' WHERE usu_id = '$id'";

    mysqli_query($link, $sql);

    echo "<script>window.alert('Usuário alterado com sucesso!');</script>";
    echo "<script>window.location.href='Lista de Usuarios.php';</script>";
}

# Coletando os dados passados via GET
$id = $_GET['id']; # Coletando o ID do usuário
$sql = "SELECT * FROM usuarios WHERE usu_id = '$id'";
$retorno = mysqli_query($link, $sql);

while($tbl = mysqli_fetch_array($retorno)){
    $nome = $tbl[1]; # Campo Nome
    $senha = $tbl[2]; # Campo Senha
    $ativo = $tbl[3]; # Campo Ativo
    # $tempero = $tbl[4]; # Campo Tempero
    $senha2 = $senha; # Campo Senha2 para verificar se foi feita alguma mudança
}

?>

<!DOCTYPE html lang="pt-br">
<html>

<head>
    <link rel="stylesheet" rel="stylesheet" href="./Css/Visão Adm.css">
</head>

<body>
    <div>
        <form action="Altera usuario.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= $nome ?>" required>
            <label>Senha</label>
            <input type="password" name="senha" value="<?= $senha ?>">
            <p></p>
            <label>Status: <?= ($ativo == 's') ? "Ativo" : "Inativo" ?></label>
            <p></p>
            <input type="radio" name="ativo" value="s" <?= $ativo == "s" ? "checked" : "" ?>>Ativo<br>
            <input type="radio" name="ativo" value="n" <?= $ativo == "n" ? "checked" : "" ?>>Inativo<br>

            <input type="submit" value="salvar">
        </form>
    </div>
</body>

</html>