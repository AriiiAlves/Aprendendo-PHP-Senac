<?php

include('../../functions/conectadb.php');
include('../../functions/session_validation_client.php');

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
    <link rel="stylesheet" href="../../../styles/client_home.css">
    <link rel="stylesheet" href="../../../styles/profile_client.css">
</head>
<body>
    <div class="profile_box">
        <div class="home">
            <a href="home.php">Home</a>
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