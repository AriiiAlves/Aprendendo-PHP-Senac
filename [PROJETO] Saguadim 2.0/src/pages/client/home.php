<?php

include('../../functions/conectadb.php');
// Valida se há um usuário logado. Se não, retorna à página de login
include('../../functions/session_validation_client.php');

// Script de ação ao botão "sair"
if (isset($_POST['sair'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para o index.php
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/index.php");
    exit(); // Certifique-se de encerrar o script após o redirecionamento
}

// Seleciona a quantidade de encomendas em preparo ou aguardando retirada para notificação
$sql = "SELECT COUNT(DISTINCT fk_ven_id) FROM encomendas WHERE fk_cli_id = " . $_SESSION['idusuario'] . " AND (enc_status = 's' OR enc_status = 'a')";
$pedidos = mysqli_fetch_array(mysqli_query($link, $sql))[0];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../styles/client_home.css">
</head>
<body>
    <div class="profile_box">
        <div class="profile" id="profile">
            <img src="../../../public/photos/avatar.png">
            <span><?=$_SESSION['nomeusuario']?></span>
        </div>
        <div class="details" id="details">
            <a href="profile.php?id=<?=$_SESSION['idusuario']?>">Perfil</a>
            <form method="post" action="">
                <input type="submit" name="sair" value="Sair">
            </form>
        </div>
    </div>
    <div class="cards">
        <a href="encomendar/order.php">
            <div>
                <img src="../../../public/photos/drive-through.png">
                <p>Encomendar</p>
            </div>
        </a>
        <a href="pedidos/requests_home.php">
            <div>
                <?php

                // Se houver encomendas em preparo ou aguardando retirada, mostra a notificação 
                if($pedidos > 0) {
                ?>
                    <span><?= $pedidos ?></span>
                <?php
                }
                ?>
                <img src="../../../public/photos/saco-de-papel.png">
                <p>Pedidos</p>
            </div>
        </a>
        <!-- Não há uma estrutura o suficiente no banco de dados para suportar adição e controle de saldo
        <a href="financeiro/payments.php">
            <div>
                <img src="../../../public/photos/money-bag.png">
                <p>Saldo e extrato</p>
            </div>
        </a>
            -->
    </div>
    <div class="credits">
        <p> 
            Ícones feitos por 
            <a href="https://www.flaticon.com/br/autores/berkahicon" title="berkahicon"> berkahicon, </a>
            <a href="https://www.flaticon.com/br/icones-gratis/casa" title="casa ícones">Good Ware, </a>
            <a href="https://www.flaticon.com/free-icons/back" title="back icons">Jesus Chavarria, </a>
            <a href="https://www.flaticon.com/br/icones-gratis/saco-de-papel" title="saco de papel ícones">Smashicons, </a> e
            <a href="https://www.flaticon.com/br/icones-gratis/drive-through" title="drive-through ícones">Freepik</a>
            de <a href="https://www.flaticon.com/br/" title="Flaticon">www.flaticon.com</a>
        </p>
    </div>
    <script>
        // Carrega os eventos ao carregar a DOM
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
    </script>
</body>
</html>