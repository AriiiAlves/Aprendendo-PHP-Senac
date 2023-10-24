<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="./Css/Cadastro.css">
</head>

<?php

# Inicia a conexão com o banco de dados
include("Conexão com banco.php");

# Passando uma instrução ao banco de dados
$sql = "SELECT * FROM produtos WHERE pd_ativo = 's'";
$retorno = mysqli_query($link, $sql);

# Força sempre trazer 'S' na variável para utilizarmos nos radio buttons
$ativo = "s";

# Coleta o submit do botão via método POST vindo do HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ativo = $_POST['ativo'];

    # Verifica se o usuário está ativo para listar
    # Se 'S', lista, senão, lista os usuários inativos
    if ($ativo == 's') {
        $sql = "SELECT * FROM produtos WHERE pd_ativo = 's'";
        $retorno = mysqli_query($link, $sql);
    } else {
        $sql = "SELECT * FROM produtos WHERE pd_ativo = 'n'";
        $retorno = mysqli_query($link, $sql);
    }
}

?>

<body>
    <div id="background">
        <form action="Lista de Produtos.php" method="post">
            <input type="radio" name="ativo" class="radio" value="s" required onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>> Ativos
            <input type="radio" name="ativo" class="radio" value="n" required onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>> Inativos
        </form>

        <div class="container">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Imagem</th>
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
                        <!-- Traz somente a coluna 0 [ID] do banco -->
                        <td><?= $tbl[0] ?></td>
                        <!-- Traz somente a coluna 1 [Nome] do banco -->
                        <td><?= $tbl[1] ?></td>
                        <!-- Traz somente a coluna 2 [Descrição] do banco -->
                        <td><?= $tbl[2] ?></td>
                        <!-- Traz somente a coluna 3 [Quantidade] do banco -->
                        <td><?= $tbl[3] ?></td>
                        <!-- Traz somente a coluna 4 [Preço] do banco -->
                        <td><label>R$ <?= number_format($tbl[4], 2) ?></td>
                        <!-- Traz somente a coluna 5 [Imagem] do banco -->
                        <td><img width="90px" height="90px" src="data:image/png;base64,<?= $tbl[6] ?>"></td>
                        <!-- Ao clicar no botão ele já traz o id do usuário para a página do alt -->
                        <td>
                            <a href="alterausuario.php?id=<? $tbl[0] ?>">
                                <input type="button" value="Alterar Dados">
                            </a>
                        </td>

                        <td><?= $check = ($tbl[5] == "s") ? "Sim" : "Não" ?></td>
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