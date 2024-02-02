<?php

// Valida se há um usuário logado. Se não, retorna à página de login
include('../../functions/session_validation_user.php');

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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../styles/admin_home.css">
</head>
<body>
    <nav>
        <img src="../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="cadastro/user.php">Usuário</a></li> 
                <li><a href="cadastro/client.php">Cliente</a></li>
                <li><a href="cadastro/product.php">Produto</a></li>
                <li><a href="cadastro/supplier.php">Fornecedor</a></li>
                
            </ul>
            <h2>Lista</h2>
            <ul>
                <li><a href="lista/user.php">Usuário</a></li> 
                <li><a href="lista/client.php">Cliente</a></li>
                <li><a href="lista/product.php">Produto</a></li>
                <li><a href="lista/supplier.php">Fornecedor</a></li>
            </ul>
            <h2>Encomendas</h2>
            <ul>
                <li><a href="encomendas/requests.php">Solicitadas</a></li> 
                <li><a href="encomendas/waiting.php">Aguardando entrega</a></li>
                <li><a href="encomendas/concluded.php">Concluídas</a></li>
            </ul>
        </div>
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
    </nav>
    <main>
    </main>
</body>
</html>

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