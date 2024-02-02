<?php

include('../../functions/conectadb.php');
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

// Definindo id do usuário para botão de perfil
$usu_id = $_SESSION['idusuario'];

// Buscando o nome e email do usuário com seu id
$sql = "SELECT usu_login, usu_email FROM usuarios WHERE usu_id = $usu_id";
$retorno = mysqli_query($link, $sql);

while ($tbl = mysqli_fetch_array($retorno)) {
    $login = $tbl[0];
    $email = $tbl[1];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../styles/profile.css">
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
                <li><a href="encomendas/waiting.php">Aguardando retirada</a></li>
                <li><a href="encomendas/concluded.php">Concluídas</a></li>
            </ul>
        </div>
        <div class="profile" id="profile">
                <img src="../../../public/photos/avatar.png">
                <span><?=$_SESSION['nomeusuario']?></span>
        </div>
        <div class="details" id="details">
            <a href="profile.php">Perfil</a>
            <form method="post" action="">
                <input type="submit" name="sair" value="Sair">
            </form>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="divider">
                <div class="photo">
                    <img src="../../../public/photos/avatar.png">
                    <p><?=$_SESSION['nomeusuario']?></p>
                </div>
                <div class="info">
                    <label>Login</label>
                    <input type="text" name="login" value="<?= $login ?>" readonly>
                    <label>Email</label>
                    <input type="email" value="<?= $email ?>" readonly>
                </div>
            </div>
            <div class="divider">
                <div class="password">
                    <span>Mudar senha</span>
                    <hr>
                    <label for="senha">Senha antiga</label>
                    <input type="password" id="senha">
                    <label for="nova_senha">Nova senha</label>
                    <input type="password" id="nova_senha">
                    <label for="nova_senha2">Confirme a nova senha</label>
                    <input type="password" id="nova_senha2">
                    <span id="error"></span>
                    <button value="Entrar" onclick="submitForm()">Atualizar senha</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

<script>
    // Carregando eventos ao carregar a DOM
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

    // Coleta os dados e envia por AJAX, para não precisar ir e voltar do arquivo PHP
    function submitForm() {
        var senha = document.getElementById('senha').value;
        var nova_senha = document.getElementById('nova_senha').value;
        var nova_senha2 = document.getElementById('nova_senha2').value;

        if(nova_senha === nova_senha2) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../functions/change_user_password.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            // Callback a ser executado quando a resposta do servidor for recebida
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.responseText);
                    console.log(typeof(xhr.responseText));
                    var response = xhr.responseText;
                    
                    // Se a resposta for "0", mostra a mensagem de erro
                    if(response === "0") {
                        document.getElementById('error').style.display = 'none';
                        document.getElementById('error').innerHTML = 'Senha incorreta';
                        document.getElementById('error').style.display = 'block';
                    }
                    // Se a resposta for "1", redireciona para a home
                    else if (response === "1") {
                        document.getElementById('error').style.display = 'none';
                        window.alert("Senha alterada com sucesso!")
                        senha.value = '';
                        nova_senha.value = '';
                        nova_senha2.value = '';
                    }
                }
            };
        
            // Converte os dados para a notação de URL
            var params = 'senha=' + senha + '&nova_senha=' + nova_senha;
            
            xhr.send(params);
        }
        else {
            document.getElementById('error').style.display = 'none';
            document.getElementById('error').innerHTML = 'Senhas não conferem';
            document.getElementById('error').style.display = 'block';
        }
    }
</script>