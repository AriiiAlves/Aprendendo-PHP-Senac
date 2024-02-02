<?php

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
    <title>Cadastrar usuário</title>
    <link rel="stylesheet" href="../../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../../styles/admin_register.css">
</head>
<body>
    <nav>
        <img src="../../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="user.php" class="selected">Usuário</a></li> 
                <li><a href="client.php">Cliente</a></li>
                <li><a href="product.php">Produto</a></li>
                <li><a href="supplier.php">Fornecedor</a></li>
                
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
                <li><a href="../encomendas/requests.php">Solicitadas</a></li> 
                <li><a href="../encomendas/waiting.php">Aguardando entrega</a></li>
                <li><a href="../encomendas/concluded.php">Concluídas</a></li>
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
        <div class="container">
            <div>
                <input type="text" name="nome" id="nome" placeholder="Nome de usuário" required>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <input type="password" name="senha" id="senha" placeholder="Senha" required>
                <input type="password" name="senha" id="senha2" placeholder="Confirme a senha" required>
                <span id="error"></span>
                <button value="Entrar" onclick="submitForm()">Cadastrar usuário</button>
            </div>
        </div>
    </main>
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

        function submitForm() {
            var login = document.getElementById('nome').value;
            var email = document.getElementById('email').value;
            var senha = document.getElementById('senha').value;
            var senha2 = document.getElementById('senha2').value;
            
            if(senha === senha2) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../../../functions/admin_register.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
                // Callback a ser executado quando a resposta do servidor for recebida
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = xhr.responseText;
                        
                        // Se a resposta for "0", mosexibe um erro (usuário já existe)
                        if(response === "0") {
                            document.getElementById('error').style.display = 'none';
                            document.getElementById('error').innerHTML = 'O usuário já existe.';
                            document.getElementById('error').style.display = 'block';
                        }
                        // Se a resposta for "1", mostra uma mensagem de sucesso
                        else if (response === "1") {
                            document.getElementById('error').style.display = 'none';
                            window.alert("Cadastro realizado com sucesso!");
                            window.location.reload();
                        }
                    }
                };
            
                // Converte os dados para a notação de URL
                var params = 'login=' + login + '&email=' + email + '&senha=' + senha;
                
                xhr.send(params);
            }
            else {
                document.getElementById('error').style.display = 'none';
                document.getElementById('error').innerHTML = 'Senhas não conferem!';
                document.getElementById('error').style.display = 'block';
            }
        }
    </script>
</body>
</html>