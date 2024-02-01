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

$sql = "SELECT DISTINCT COUNT(fk_ven_id) FROM encomendas WHERE fk_cli_id = " . $_SESSION['idusuario'] . " AND enc_status = 's'";
$emPreparo = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT DISTINCT COUNT(fk_ven_id) FROM encomendas WHERE fk_cli_id = " . $_SESSION['idusuario'] . " AND enc_status = 'a'";
$aguardandoRetirada = mysqli_fetch_array(mysqli_query($link, $sql))[0];

$sql = "SELECT DISTINCT COUNT(fk_ven_id) FROM encomendas WHERE fk_cli_id = " . $_SESSION['idusuario'] . " AND enc_status = 'n'";
$entregues = mysqli_fetch_array(mysqli_query($link, $sql))[0];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../../styles/client_home.css">
    <link rel="stylesheet" href="../../../../styles/profile_client.css">
    <link rel="stylesheet" href="../../../../styles/requests_home.css">
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
    <div class="cards">
        <a href="preparing.php">
            <div>
                <?php
                
                if($emPreparo > 0) {
                ?>
                    <span><?= $emPreparo ?></span>
                <?php
                }
                ?>
                
                <img src="../../../../public/photos/drive-through.png">
                <p>Em preparo</p>
            </div>
        </a>
        <a href="waiting.php">
            <div>
                <?php
                
                if($aguardandoRetirada > 0) {
                ?>
                    <span><?= $aguardandoRetirada ?></span>
                <?php
                }
                ?>
                <img src="../../../../public/photos/saco-de-papel.png">
                <p>Aguardando retirada</p>
            </div>
        </a>
        <a href="concluded.php">
            <div>
                <?php
                
                if($entregues > 0) {
                ?>
                    <span><?= $entregues ?></span>
                <?php
                }
                ?>
                <img src="../../../../public/photos/saco-de-papel.png">
                <p>Entregues</p>
            </div>
        </a>
    </div>
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
    </script>
</body>
</html>