<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de usuários</title>
    <link rel="stylesheet" href="./Css/Visão Adm.css">
</head>

<?php

include("Cabecalho.php");

# Passando uma instrução ao banco de dados
$sql = "SELECT * FROM usuarios WHERE usu_ativo = 's'";
$retorno = mysqli_query($link, $sql);

# Força sempre trazer 'S' na variável para utilizarmos nos radio buttons
$ativo = "s";

# Coleta o submit do botão via método POST vindo do HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ativo = $_POST['ativo'];

    # Verifica se o usuário está ativo para listar
    # Se 'S', lista, senão, lista os usuários inativos
    if ($ativo == 's') {
        $sql = "SELECT * FROM usuarios WHERE usu_ativo = 's'";
        $retorno = mysqli_query($link, $sql);
    } else if ($ativo == 'all'){
        $sql = "SELECT * FROM usuarios WHERE usu_ativo = 's' or usu_ativo = 'n'";
        $retorno = mysqli_query($link, $sql);
    }
    else {
        $sql = "SELECT * FROM usuarios WHERE usu_ativo = 'n'";
        $retorno = mysqli_query($link, $sql);
    }
}

?>

<body>
    <div id="background">
        <form action="Lista de Usuarios.php" method="post">
            <input type="radio" name="ativo" class="radio" value="s" required onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>> Ativos
            <input type="radio" name="ativo" class="radio" value="n" required onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>> Inativos
            <input type="radio" name="ativo" class="radio" value="all" required onclick="submit()" <?= $ativo == 'all' ? "checked" : "" ?>> Todos
        </form>

        <div class="container">
            <table border="1">
                <tr>
                    <th>Nome</th>
                    <th>Alterar dados</th>
                    <th>Ativo?</th>
                </tr>

                <!-- Início de PHP + HTML -->
                <?php

                # Fazendo preenchimento da tabela usando while (enquanto há dados, preenche)
                # Abrindo while (alterna entre PHP e HTML, e depois o while fecha)
                while ($tbl = mysqli_fetch_array($retorno)) {
                    # Mas aqui fecho o código PHP para trabalhar com HTML simultaneamente

                ?>

                    <tr>
                        <!-- Traz somente a coluna 1 [Nome] do banco -->
                        <td><?= $tbl[1] ?></td>
                        <!-- Ao clicar no botão ele já traz o id do usuário para a página do alt -->
                        <td>
                            <a href="Altera usuario.php?id=<?= $tbl[0] ?>">
                                <input type="button" value="Alterar Dados">
                            </a>
                        </td>

                        <td><?= $check = ($tbl[3] == "s") ? "Sim" : "Não" ?></td>
                    </tr>

                <?php
                    # Fechando while
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>