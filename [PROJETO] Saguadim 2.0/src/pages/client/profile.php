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

$cli_id = $_SESSION['idusuario'];

// Seleciona todos os dados do usuário
$sql = "SELECT * FROM clientes WHERE cli_id = $cli_id";
$retorno = mysqli_query($link, $sql);

while($tbl = mysqli_fetch_array($retorno)) {
    $cli_id = $tbl[0];
    $nome = $tbl[1];
    $email = $tbl[2];
    $senha = $tbl[3];
    $telefone = $tbl[4];
    $cpf = $tbl[5];
    $curso = $tbl[6];
    $sala = $tbl[7];
    $status = $tbl[8];
    $saldo = $tbl[9];
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saguadim</title>
    <link rel="stylesheet" href="../../../styles/client_home.css">
    <link rel="stylesheet" href="../../../styles/profile_client.css">
</head>
<body>
    <div class="profile_box">
        <div class="home">
            <a href="home.php">
                <img src="../../../public/photos/house.png">
            </a>
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
    </div>
    <div class="container">
        <div class="divider">
            <div class="divider_in">
                <div class="photo">
                    <img src="../../../public/photos/avatar.png">
                    <p><?=$_SESSION['nomeusuario']?></p>
                </div>
                <div class="info">
                    <label>Nome completo</label>
                    <input type="text" name="nome" id="nome" value="<?= $nome ?>" readonly>
                    <label>Email</label>
                    <input type="email" name="email" id="email" value="<?= $email ?>" readonly>
                    <label>Celular</label>
                    <input type="tel" name="celular" id="celular" minlength="15" maxlength="15" value="<?= $telefone ?>" readonly>
                </div>
            </div>
            <div class="divider_in">
                <div class="info">
                    <label>CPF</label>
                    <input type="email" name="cpf" id="cpf" minlength="14" maxlength="14" value="<?= $cpf ?>" readonly>
                    <label>Curso atual (Senac)</label>
                    <input type="text" name="curso" id="curso" value="<?= $curso ?>" readonly>
                    <label>Número da sala</label>
                    <input type="number" name="sala" id="sala" step="1" min="1" max="99" value="<?= $sala ?>" readonly>
                    <label>Status</label>
                    <input type="text" name="status" id="status" value="<?= $status == 's' ? 'Ativo' : 'Inativo' ?>" readonly>
                    <label>Saldo</label>
                    <input type="number" name="saldo" id="saldo" min="0" step="1" value="<?= number_format($saldo, 2, '.') ?>" readonly>
                </div>
            </div>
        </div>
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

    // Script AJAX que tenta alterar a senha e retorna uma resposta
    function submitForm() {
        var senha = document.getElementById('senha').value;
        var nova_senha = document.getElementById('nova_senha').value;
        var nova_senha2 = document.getElementById('nova_senha2').value;

        if(nova_senha === nova_senha2) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../functions/change_client_password.php', true);
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
                        window.restart();
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