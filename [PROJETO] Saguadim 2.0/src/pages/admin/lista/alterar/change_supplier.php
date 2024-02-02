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
$fornecedor_id = $_GET['id'];

$sql = "SELECT fornecedor_nome FROM fornecedores WHERE fornecedor_id = $fornecedor_id";
$fornecedor_nome = mysqli_fetch_array(mysqli_query($link, $sql))[0];

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
                <li><a href="../../cadastro/client.php">Cliente</a></li>
                <li><a href="../../cadastro/product.php">Produto</a></li>
                <li><a href="../../cadastro/supplier.php" class="selected">Fornecedor</a></li>
                
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
        <div class="container client edit_supplier">
            <div>
                <label>Nome do fornecedor</label>
                <input type="text" name="fornecedor_nome" id="fornecedor_nome" placeholder="Nome do fornecedor" value="<?= $fornecedor_nome ?>" required>
                <span id="error"></span>
                <button value="Editar" onclick="submitForm()">Editar fornecedor</button>
            </div>
        </div>
    </main>
    <script>
        // Carregando eventos ao carregar a DOM
        document.addEventListener('DOMContentLoaded', function() {
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
            var fornecedor_nome = document.getElementById('fornecedor_nome').value;
        
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../../functions/change_supplier.php', true);
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
                        window.alert("Fornecedor editado com sucesso!")
                    }
                }
            }

            // Converte os dados para a notação de URL
            var params = `fornecedor_id=${<?= $fornecedor_id ?>}&fornecedor_nome=${fornecedor_nome}`;
                
            xhr.send(params);
        }
    </script>
</body>
</html>