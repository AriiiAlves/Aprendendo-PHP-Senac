<?php

include('../../../functions/conectadb.php');
include('../../../functions/session_validation_client.php');

if (isset($_POST['sair'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para o index.php
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/index.php");
    exit(); // Certifique-se de encerrar o script após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../../styles/client_home.css">
    <link rel="stylesheet" href="../../../../styles/profile_client.css">
    <link rel="stylesheet" href="../../../../styles/requests.css">
</head>
<body>
    <div class="profile_box">
        <div class="home">
            <a href="../home.php">
                <img src="../../../../public/photos/house.png">
            </a>
        </div>
        <div class="home">
            <a href="requests_home.php">
                <img src="../../../../public/photos/return.png">
            </a>
        </div>
        <div class="profile" id="profile">
            <img src="../../../../public/photos/avatar.png">
            <span><?=$_SESSION['nomeusuario']?></span>
        </div>
        <div class="details" id="details">
            <a href="profile.php?id=<?=$_SESSION['idusuario']?>">Perfil</a>
            <form method="post" action="">
                <input type="submit" name="sair" value="Sair">
            </form>
        </div>
    </div>
    <div class="order">
        <h2>Pedidos encomendados</h2>
            <?php

            $sql = "SELECT DISTINCT fk_ven_id FROM encomendas WHERE enc_status = 's'";
            $retorno = mysqli_query($link, $sql);

            while($tbl = mysqli_fetch_array($retorno)) {
                $codigoVenda = $tbl[0];

                $sql = "SELECT DISTINCT enc_emissao, enc_entrega FROM encomendas WHERE fk_ven_id = "  . $codigoVenda;
                $dataPedido = mysqli_fetch_array(mysqli_query($link, $sql))[0];
                $dataPedido = substr($dataPedido, 8, 2) . '/' . substr($dataPedido, 5, 2) . '/' . substr($dataPedido, 0, 4);
                $dataEntrega = mysqli_fetch_array(mysqli_query($link, $sql))[1];
                $dataEntrega = substr($dataEntrega, 8, 2) . '/' . substr($dataEntrega, 5, 2) . '/' . substr($dataEntrega, 0, 4);
                ?>

                <button onclick="viewTable(<?= $codigoVenda ?>)">
                    <h3>Pedido para o dia <span><?= $dataEntrega ?><span></h3>
                    <p>ID do pedido: <?= $codigoVenda ?></p>
                    <p>Data de emissão: <?= $dataPedido ?></p>
                    <p>Situação: Encomendado</p>
                </button>
                <img src="../../../../public/photos/arrow.png" id="arrow<?= $codigoVenda ?>">
                <table id="table<?= $codigoVenda ?>">
                    <th>Nome do produto</th>
                    <th>Quantidade</th>
                    <th>Preço unitário (R$)</th>
                    <th>Preço total (R$)</th>
                    <?php
                    
                    $sql = "SELECT pro_nome, iv_quantidade, pro_preco, iv_total 
                    FROM item_venda 
                    INNER JOIN produtos 
                    ON item_venda.fk_pro_id = produtos.pro_id
                    WHERE iv_codigo = " . $codigoVenda;

                    $retorno2 = mysqli_query($link, $sql);
                    while($tbl2 = mysqli_fetch_array($retorno2)) {
                        $nome = $tbl2[0];
                        $quantidade = $tbl2[1];
                        $preco = $tbl2[2];
                        $total = $tbl2[3];

                        ?>
                        <tr>
                            <td><?= $nome ?></td>
                            <td><?= $quantidade ?></td>
                            <td><?= $preco ?></td>
                            <td><?= $total ?></td>
                        </tr>
                        <?php
                    }

                    $sql = "SELECT SUM(iv_quantidade), SUM(iv_total) FROM item_venda WHERE iv_codigo = " . $codigoVenda;
                    $quantidadeTotal = mysqli_fetch_array((mysqli_query($link, $sql)))[0];
                    $valorTotal = mysqli_fetch_array((mysqli_query($link, $sql)))[1];

                    ?>
                        <tr>
                            <td>Total</td>
                            <td><?= $quantidadeTotal ?></td>
                            <td>-</td>
                            <td><?= $valorTotal ?></td>
                        </tr>
                    </table>

                    <?php
                }

                ?>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var profile = document.getElementById("profile");
            var details = document.getElementById("details");

            profile.addEventListener('click', function(event) {
                event.stopPropagation();
                if (details.style.display === 'block') {
                    details.style.display = 'none';
                    details.style.opacity = '0';
                }
                else {
                    details.style.display = 'block';
                    details.style.opacity = '1';
                }
            });
        });

        function viewTable(index) {
            table = document.getElementById('table' + index);
            arrow = document.getElementById('arrow' + index);

            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'block';
                arrow.style.display = 'block';
            }
            else {
                table.style.display = 'none';
                arrow.style.display = 'none';
            }
        }
    </script>
</body>
</html>