<?php

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
            
            <div class="product_card">
                <div class="title_card">
                    <span>Título do produtoTítulo do produtoTítulo do produtoTítulo do produtoTítulo do produto</span>
                </div>
                <div class="desc_card">
                    <span>Descrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortada</span>
                </div>
                <div class="price_card">
                    <span>R$ 9,99</span>
                </div>
                <div class="end_card">
                    <input type="number" step="1" min="1" max="100" value="0"></input>
                    <button>Adicionar</button>
                </div>
            </div>
            <div class="product_card">
                <div class="title_card">
                    <span>Título do produtoTítulo do produtoTítulo do produtoTítulo do produtoTítulo do produto</span>
                </div>
                <div class="desc_card">
                    <span>Descrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortada</span>
                </div>
                <div class="price_card">
                    <span>R$ 9,99</span>
                </div>
                <div class="end_card">
                    <input type="number" step="1" min="1" max="100" value="0"></input>
                    <button>Adicionar</button>
                </div>
            </div>
            <div class="product_card">
                <div class="title_card">
                    <span>Título do produtoTítulo do produtoTítulo do produtoTítulo do produtoTítulo do produto</span>
                </div>
                <div class="desc_card">
                    <span>Descrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortada</span>
                </div>
                <div class="price_card">
                    <span>R$ 9,99</span>
                </div>
                <div class="end_card">
                    <input type="number" step="1" min="1" max="100" value="0"></input>
                    <button>Adicionar</button>
                </div>
            </div>
            <div class="product_card">
                <div class="title_card">
                    <span>Título do produtoTítulo do produtoTítulo do produtoTítulo do produtoTítulo do produto</span>
                </div>
                <div class="desc_card">
                    <span>Descrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortada</span>
                </div>
                <div class="price_card">
                    <span>R$ 9,99</span>
                </div>
                <div class="end_card">
                    <input type="number" step="1" min="1" max="100" value="0"></input>
                    <button>Adicionar</button>
                </div>
            </div>
            <div class="product_card">
                <div class="title_card">
                    <span>Título do produtoTítulo do produtoTítulo do produtoTítulo do produtoTítulo do produto</span>
                </div>
                <div class="desc_card">
                    <span>Descrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortadaDescrição cortada</span>
                </div>
                <div class="price_card">
                    <span>R$ 9,99</span>
                </div>
                <div class="end_card">
                    <input type="number" step="1" min="1" max="100" value="0"></input>
                    <button>Adicionar</button>
                </div>
            </div>
        </div>
        <div class="chosen">
            <h2>Produtos selecionados</h2>
            <table>
                <th>Nome do produto</th>
                <th>Quantidade</th>
                <th>Preço unitário (R$)</th>
                <th>Preço total (R$)</th>
                <tr>
                    <td>Esfiha</td>
                    <td>5</td>
                    <td>5</td>
                    <td>25</td>
                    <td><button>Excluir</button></td>
                </tr>
            </table>
        </div>
        <div class="end">
            <button>Finalizar pedido</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let profile = document.getElementById("profile");
            let details = document.getElementById("details");
            let leftButton = document.getElementById("left");
            let rightButton = document.getElementById("right");

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

                if(cards[i].style.left === '0px' || cards[i].style.left === '') {
                    cards[i].style.left = '-75px';
                }
                else if(leftValue > chooseNewSize + 805) {
                    cards[i].style.left = leftValue - 220 + 'px';
                }
                else if (leftValue === chooseNewSize + 805) {
                    cards[i].style.left = leftValue - 90 + 'px';
                }
            }
        }
    </script>
</body>
</html>