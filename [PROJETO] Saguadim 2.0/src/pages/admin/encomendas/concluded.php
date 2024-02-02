<?php

include('../../../functions/conectadb.php');
include('../../../functions/session_validation_user.php');

if (isset($_POST['sair'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para o index.php
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de clientes</title>
    <link rel="stylesheet" href="../../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../../styles/requests.css">
    <link rel="stylesheet" href="../../../../styles/admin_delivery.css">
</head>
<body>
    <nav>
        <img src="../../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="../cadastro/user.php">Usuário</a></li> 
                <li><a href="../cadastro/client.php">Cliente</a></li>
                <li><a href="../cadastro/product.php">Produto</a></li>
                <li><a href="../cadastro/supplier.php">Fornecedor</a></li>
                
            </ul>
            <h2>Lista</h2>
            <ul>
                <li><a href="../lista/user.php">Usuário</a></li> 
                <li><a href="../lista/client.php">Cliente</a></li>
                <li><a href="../lista/product.php">Produto</a></li>
                <li><a href="../lista/supplier.php">Fornecedor</a></li>
            </ul>
            <h2>Encomendas</h2>
            <ul>
                <li><a href="requests.php">Solicitadas</a></li> 
                <li><a href="waiting.php">Aguardando retirada</a></li>
                <li><a href="concluded.php" class="selected">Concluídas</a></li>
            </ul>
        </div>
        <div class="profile" id="profile">
                <img src="../../../../public/photos/avatar.png">
                <span><?=$_SESSION['nomeusuario']?></span>
        </div>
        <div class="details" id="details">
            <a href="../profile.php?id=<?=$_SESSION['idusuario']?>">Perfil</a>
            <form method="post" action="">
                <input type="submit" name="sair" value="Sair">
            </form>
        </div>
    </nav>
    <main>
        <div class="order">
        <h2>Pedidos finalizados</h2>
            <?php

            $sql = "SELECT DISTINCT fk_ven_id FROM encomendas WHERE enc_status = 'n'";
            $retorno = mysqli_query($link, $sql);

            while($tbl = mysqli_fetch_array($retorno)) {
                $codigoVenda = $tbl[0];

                $sql = "SELECT DISTINCT enc_emissao, enc_entrega, fk_cli_id FROM encomendas WHERE fk_ven_id = "  . $codigoVenda;
                $dataPedido = mysqli_fetch_array(mysqli_query($link, $sql))[0];
                $dataPedido = substr($dataPedido, 8, 2) . '/' . substr($dataPedido, 5, 2) . '/' . substr($dataPedido, 0, 4);
                $dataEntrega = mysqli_fetch_array(mysqli_query($link, $sql))[1];
                $dataEntrega = substr($dataEntrega, 8, 2) . '/' . substr($dataEntrega, 5, 2) . '/' . substr($dataEntrega, 0, 4);
                $cliId = mysqli_fetch_array(mysqli_query($link, $sql))[2];

                ?>

                <button onclick="viewTable(<?= $codigoVenda ?>)">
                    <h3>Pedido para o dia <span><?= $dataEntrega ?><span></h3>
                    <p>ID do pedido: <?= $codigoVenda ?></p>
                    <p>Data de emissão: <?= $dataPedido ?></p>
                    <p>Situação: Concluído</p>
                </button>
                <img src="../../../../public/photos/arrow.png" id="arrow<?= $codigoVenda ?>">
                <div id="info<?= $codigoVenda ?>" class="info">
                    <h3>Dados do cliente</h3>
                    <?php 
                    
                    $sql = "SELECT cli_nome, cli_curso, cli_sala, cli_cpf, cli_telefone FROM clientes WHERE cli_id = "  . $cliId;
                    $dadosCliente = mysqli_query($link, $sql);
                    while($tbl = mysqli_fetch_array($dadosCliente)) {
                        ?>

                    <p><b>Nome:</b> <?= $tbl[0] ?></p>
                    <p><b>Curso (Senac):</b> <?= $tbl[1] ?></p>
                    <p><b>Número da sala:</b> <?= $tbl[2] ?></p>
                    <p><b>CPF:</b> <?= $tbl[3] ?></p>
                    <p><b>Celular:</b> <?= $tbl[4] ?></p>

                        <?php
                    }
                    
                    ?>
                    <div>
                        <button onclick="deliveryState(<?= $codigoVenda ?>, 's')" class="requests">Em preparação</button>
                        <button onclick="deliveryState(<?= $codigoVenda ?>, 'a')" class="waiting">Pronto para retirada</button>
                    </div>
                </div>
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
        </table>
    </div>
    </main>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let profile = document.getElementById("profile");
        let details = document.getElementById("details");

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

        document.addEventListener('click', function(event) {
            details.style.display = 'none';
            details.style.opacity = 1;
        });
    });

    function viewTable(index) {
            table = document.getElementById('table' + index);
            arrow = document.getElementById('arrow' + index);
            info = document.getElementById('info' + index);

            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'block';
                arrow.style.display = 'block';
                info.style.display = 'block';
            }
            else {
                table.style.display = 'none';
                arrow.style.display = 'none';
                info.style.display = 'none';
            }
        }

    // Script AJAX que tenta excluir um cliente e retorna uma resposta
    function deliveryState(vendaId, estado) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../../../functions/change_delivery_state.php?vendaid=' + vendaId + '&estado=' + estado, true);
        
        // Callback a ser executado quando a resposta do servidor for recebida
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                console.log(response);
                // Se a resposta for "0", exibe um erro
                if(response === "0") {
                    window.alert("Ocorreu um erro.")
                }
                // Se a resposta for "1", mostra uma mensagem de sucesso
                else if (response === "1" && estado === "s") {
                    window.alert("Encomenda movida para 'Solicitadas' com sucesso.")
                    window.location.reload();
                }
                else if (response === "1" && estado === "a") {
                    window.alert("Encomenda movida para 'Aguardando retirada' com sucesso.")
                    window.location.reload();
                }
            }
        }
            
        xhr.send();
    }
</script>