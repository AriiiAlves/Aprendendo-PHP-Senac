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
    <link rel="stylesheet" href="../../../../styles/order.css">
</head>
<body>
    <div class="profile_box">
        <div class="home">
            <a href="../home.php">
                <img src="../../../../public/photos/house.png">
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
    <div class="order_container">
        <div class="choose_new" id="choose_new">
            <h2>Catálogo</h2>
            <button id="left" onclick="leftClick()">
                <img src="../../../../public/photos/arrow.png">
            </button>
            <button id="right" onclick="rightClick()">
                <img src="../../../../public/photos/arrow.png">
            </button>

            <?php 
            
            $sql = "SELECT pro_id, pro_nome, pro_descricao, pro_preco, pro_quantidade, pro_status FROM produtos";
            $retorno = mysqli_query($link, $sql);

            while($tbl = mysqli_fetch_array($retorno)) {
                $id = $tbl[0];
                $nome = $tbl[1];
                $descricao = $tbl[2];
                $preco = $tbl[3];
                $quantidade = $tbl[4];
                $status = $tbl[5];

                if ($status === 's') {
            ?>

                <div class="product_card">
                    <div class="title_card">
                        <span><?= $nome ?></span>
                    </div>
                    <div class="desc_card">
                        <span><?= $descricao ?></span>
                    </div>
                    <div class="price_card">
                        <span>R$ <?= number_format($preco, 2, ',', '.') ?></span>
                    </div>
                    <div class="end_card">
                        <input type="number" step="1" min="1" max="<?= $quantidade ?>" id="pro<?= $id ?>" value="0"></input>
                        <button onclick="addProduct(<?= $id ?>)">Adicionar</button>
                    </div>
                </div>

            <?php
                }
            }
            ?>
        </div>
        <div class="chosen">
            <h2>Produtos selecionados</h2>
            <table id="table">
                <th>Nome do produto</th>
                <th>Quantidade</th>
                <th>Preço unitário (R$)</th>
                <th>Preço total (R$)</th>
                <th></th>
                
                <?php
                if(isset($_SESSION['codigo_venda'])) {
                    $sql = "SELECT iv_id, iv_quantidade, iv_total, pro_nome, pro_preco FROM item_venda 
                            INNER JOIN produtos ON item_venda.fk_pro_id = produtos.pro_id
                            WHERE iv_codigo =" . $_SESSION['codigo_venda'];
                    $retorno = mysqli_query($link, $sql);

                    $total_encomenda = 0;
                    $quantidade_encomenda = 0;

                    while($tbl = mysqli_fetch_array($retorno)) {
                        $iv_id = $tbl[0];
                        $quantidade = $tbl[1];
                        $quantidade_encomenda += $quantidade;
                        $total = $tbl[2];
                        $total_encomenda += $total;
                        $nome = $tbl[3];
                        $preco = $tbl[4];
                ?>
                        <tr>
                            <td><?= $nome ?></td>
                            <td><?= $quantidade ?></td>
                            <td><?= number_format($preco, 2, ',', '') ?></td>
                            <td><?= number_format($total, 2, ',', '') ?></td>
                            <td><button onclick="deleteItem(<?= $iv_id ?>)">Excluir</button></td>
                        </tr>
                <?php
                    }
                ?>
                    <tr>
                        <td>Total</td>
                        <td><?= $quantidade_encomenda ?></td>
                        <td>-</td>
                        <td><?= number_format($total_encomenda, 2, ',', '') ?></td>
                        <td><button>Oculto</button></td>
                    </tr>
                <?php
                }
                else {
                ?>
                    <tr>
                        <td>Total</td>
                        <td>0</td>
                        <td>-</td>
                        <td>0</td>
                        <td><button>Oculto</button></td>
                    </tr>
                <?php 
                }
                ?>
            </table>
        </div>
        <div class="end">
            <button onclick="endOrder()">Finalizar pedido</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var profile = document.getElementById("profile");
            var details = document.getElementById("details");
            var leftButton = document.getElementById("left");
            var rightButton = document.getElementById("right");
            var cards = document.querySelectorAll('.product_card');
            var descCard = document.querySelectorAll('.desc_card');

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

            if (cards.length <= 3) {
                leftButton.style.display = 'none';
                rightButton.style.display = 'none';
            }
            else {
                leftButton.style.display = 'block';
                rightButton.style.display = 'block';
            }


            for (var i = 0; i < descCard.length; i++) { 
                var descSpan = descCard[i].getElementsByTagName('span')[0];
                if (descSpan.clientHeight > 58) {
                    while (descSpan.clientHeight > 58) {
                        descSpan.textContent = descSpan.textContent.slice(0, -1);
                    }
                    descSpan.textContent = descSpan.textContent.slice(0, -3);
                    descSpan.textContent = descSpan.textContent + '...';
                } 
            }
        });

        function leftClick() {
            var cards = document.querySelectorAll('.product_card');
            
            for (var i = 0; i < cards.length; i++) {
                var leftValue = cards[i].style.left;
                var chooseNewSize = 0 - (cards.length * (200 + 20));

                if(leftValue === "") {
                    leftValue = 0;
                }
                else {
                    leftValue = parseInt(leftValue.replace("px", ""));
                }

                if(cards[i].style.left === '-75px' || cards[i].style.left === '0px' || cards[i].style.left === '') {
                    cards[i].style.left = '0px';
                }
                else if (leftValue === chooseNewSize + 805 - 90) {
                    cards[i].style.left = leftValue + 90 + 'px';
                }
                else {
                    cards[i].style.left = leftValue + 220 + 'px';
                }
            }
        }

        function rightClick() {
            var cards = document.querySelectorAll('.product_card');
            var chooseNewSize = 0 - (cards.length * (200 + 20));

            for (var i = 0; i < cards.length; i++) {
                var leftValue = cards[i].style.left;

                if(leftValue === "") {
                    leftValue = 0;
                }
                else {
                    leftValue = parseInt(leftValue.replace("px", ""));
                }

                // if(cards[i].style.left === '0px' || cards[i].style.left === '') {
                //    cards[i].style.left = '-75px';
                // }
                if(leftValue > chooseNewSize + 805) {
                    cards[i].style.left = leftValue - 220 + 'px';
                }
                else if (leftValue === chooseNewSize + 805) {
                    cards[i].style.left = leftValue - 90 + 'px';
                }
            }
        }

        function addProduct(id) {
            let proInput = document.getElementById('pro' + id);
            let proQuantity = proInput.value;
            
            if (proQuantity === '0') {
                proInput.classList.add('shake');

                proInput.addEventListener('animationend', function() {
                    proInput.classList.remove('shake');
                });
            } 
            else {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../../../functions/add_cart_product.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
                // Callback a ser executado quando a resposta do servidor for recebida
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log(xhr.responseText);
                        var response = xhr.response;
                        
                        // Se a resposta for "0", mostra a mensagem de erro
                        if(response === "0") {
                            window.alert('Ocorreu um erro.');
                        }
                        // Se a resposta for "1", recarrega a página para recarregar a tabela
                        else if (response === "1") {
                            window.location.reload();
                        }
                    }
                };
            
                // Converte os dados para a notação de URL
                var params = 'pro_id=' + id + '&quantidade=' + proQuantity;
                
                xhr.send(params);
            }
        }

        function deleteItem(codigo_venda) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../functions/delete_item_venda.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            // Callback a ser executado quando a resposta do servidor for recebida
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText)
                    var response = xhr.responseText;
                    
                    // Se a resposta for "0", mostra a mensagem de erro
                    if(response === "0") {
                        window.alert('Ocorreu um erro.');
                    }
                    // Se a resposta for "1", recarrega a página
                    else if (response === "1") {
                        window.location.reload();
                    }
                }
            };
        
            // Converte os dados para a notação de URL
            var params = 'codigo_venda=' + codigo_venda;
            
            xhr.send(params);
        }

        function endOrder() {
            // Vai registrar tudo na tabela encomenda. Quando a encomenda for entregue e paga,
            // Será marcado como concluído e só assim registrado na tabela venda.
            // Importante fazer um botão de confirmação depois
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../../../functions/end_sale.php', true);
            
            // Callback a ser executado quando a resposta do servidor for recebida
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    var response = xhr.responseText;
                    
                    // Se a resposta for "0", mostra a mensagem de erro
                    if(response === "0") {
                        window.alert('Ocorreu um erro.');
                    }
                    // Se a resposta for "1", redireciona para a home
                    else if (response === "1") {
                        window.alert('Pedido realizado com sucesso!');
                        window.location = '../home.php';
                    }
                    else if(response === "void_cart") {
                        window.alert('Insira pelo menos um produto para realizar o pedido.');
                    }
                }
            };
            
            xhr.send();
        }
    </script>
</body>
</html>