<?php

include('../../../../functions/conectadb.php');
// Valida se há um usuário logado. Se não, retorna à página de login
include('../../../../functions/session_validation_user.php');

// Script de ação ao botão "sair"
if (isset($_POST['sair'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para o index.php
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/index.php");
    exit();
}

// Obtém o id do cliente a ser alterado via GET, e coleta seus dados, que serão apresentados em campos input editáveis
$cli_id = $_GET['id'];

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
    <title>Cadastrar cliente</title>
    <link rel="stylesheet" href="../../../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../../../styles/admin_register.css">
</head>
<body>
    <nav>
        <img src="../../../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="../../cadastro/user.php">Usuário</a></li> 
                <li><a href="../../cadastro/client.php" class="selected">Cliente</a></li>
                <li><a href="../../cadastro/product.php">Produto</a></li>
                <li><a href="../../cadastro/supplier.php">Fornecedor</a></li>
                
            </ul>
            <h2>Lista</h2>
            <ul>
                <li><a href="../user.php">Usuário</a></li> 
                <li><a href="../client.php">Cliente</a></li>
                <li><a href="../product.php">Produto</a></li>
                <li><a href="../supplier.php">Fornecedor</a></li>
            </ul>
            <h2>Encomendas</h2>
            <ul>
                <li><a href="../../encomendas/requests.php">Solicitadas</a></li> 
                <li><a href="../../encomendas/waiting.php">Aguardando entrega</a></li>
                <li><a href="../../encomendas/concluded.php">Concluídas</a></li>
            </ul>
        </div>
        <div class="profile" id="profile">
                <img src="../../../../../public/photos/avatar.png">
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
        <div class="container client edit_client">
            <div>
                <label>Nome completo</label>
                <input type="text" name="nome" id="nome" placeholder="Nome completo" value="<?= $nome ?>" required>
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= $email ?>" required>
                <label>Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Nova senha" value="<?= $senha ?>" required>
                <label>Confirmar senha</label>
                <input type="password" name="senha2" id="senha2" placeholder="Repita a senha" value="<?= $senha ?>" required>
                <label>Celular</label>
                <input type="tel" name="celular" id="celular" placeholder="Celular" minlength="15" maxlength="15" value="<?= $telefone ?>" required>
                <label>CPF</label>
                <input type="email" name="cpf" id="cpf" placeholder="CPF" minlength="14" maxlength="14" value="<?= $cpf ?>" required>
                <label>Curso atual (Senac)</label>
                <input type="text" name="curso" id="curso" placeholder="Curso atual (Senac)" value="<?= $curso ?>" required>
                <label>Número da sala</label>
                <input type="number" name="sala" id="sala" placeholder="Número da sala" step="1" min="1" max="99" value="<?= $sala ?>" required>
                <label>Status</label>
                <input type="radio" name="status" id="status_ativo" value="s" required <?= $status === 's' ? 'checked' : '' ?>>
                <label class="radio">Ativo</label>
                <input type="radio" name="status" id="status_inativo" value="n" required <?= $status === 'n' ? 'checked' : '' ?>>
                <label class="radio">Inativo</label>
                <label>Saldo</label>
                <input type="number" name="saldo" id="saldo" placeholder="Saldo" min="0" step="1" value="<?= number_format($saldo, 2, '.') ?>" required>
                <span id="error"></span>
                <button value="Editar" onclick="submitForm()">Editar cliente</button>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
    <script>
        // Carregando eventos ao carregar a DOM
        document.addEventListener('DOMContentLoaded', function() {
            // Máscaras de inputs
            var cellphoneInput = document.getElementById('celular');
            var cpfInput = document.getElementById('cpf');
            var salaInput = document.getElementById('sala');
            VMasker(cellphoneInput).maskPattern('(99) 99999-9999');
            VMasker(cpfInput).maskPattern('999.999.999-99');
            VMasker(salaInput).maskPattern('99');

            // Visibilidade de detalhes (Perfil/Sair) ao clicar no ícone do perfil
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

        // Script AJAX que tenta editar o cliente e retorna uma resposta
        function submitForm() {
            var nome = document.getElementById('nome').value;
            var email = document.getElementById('email').value;
            var senha = document.getElementById('senha').value;
            var senha2 = document.getElementById('senha2').value;
            var telefone = document.getElementById('celular').value;
            var cpf = document.getElementById('cpf').value;
            var curso = document.getElementById('curso').value;
            var sala = document.getElementById('sala').value;

            if (document.getElementById('status_ativo').checked) {
                var status = 's';
            }
            else if(document.getElementById('status_inativo').checked) {
                var status = 'n';
            }

            var saldo = document.getElementById('saldo').value;
        
            if (senha === senha2) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../../../../functions/change_client.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
                // Callback a ser executado quando a resposta do servidor for recebida
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = xhr.responseText;
                        console.log(response);
                        // Se a resposta for "0", exibe um erro
                        if(response === "0") {
                            document.getElementById('error').style.display = 'none';
                            document.getElementById('error').innerHTML = 'Ocorreu um erro.';
                            document.getElementById('error').style.display = 'block';
                        }
                        // Se a resposta for "1", mostra uma mensagem de sucesso
                        else if (response === "1") {
                            document.getElementById('error').style.display = 'none';
                            window.alert("Cliente editado com sucesso!")
                        }
                    }
                };
            
                // Converte os dados para a notação de URL
                var params = `cli_id=${<?= $cli_id ?>}&nome=${nome}&email=${email}&senha=${senha}&telefone=${telefone}&cpf=${cpf}&curso=${curso}&sala=${sala}&status=${status}&saldo=${saldo}`;
                
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