<?php

include('../../../functions/conectadb.php');
// Valida se há um usuário logado. Se não, retorna à página de login
include('../../../functions/session_validation_user.php');

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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar cliente</title>
    <link rel="stylesheet" href="../../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../../styles/admin_register.css">
</head>
<body>
    <nav>
        <img src="../../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="user.php">Usuário</a></li> 
                <li><a href="client.php">Cliente</a></li>
                <li><a href="product.php" class="selected">Produto</a></li>
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
            <a href="profile.php?id=<?=$_SESSION['idusuario']?>">Perfil</a>
            <form method="post" action="">
                <input type="submit" name="sair" value="Sair">
            </form>
        </div>
    </nav>
    <main>
        <div class="container product">
            <div>
                <input type="text" name="nome" id="nome" placeholder="Nome do produto" required>
                <textarea name="descricao" rows="5" id="descricao" placeholder="Descrição" required></textarea>
                <input type="number" name="custo" step="0.01" id="custo" placeholder="Custo (valor)" required>
                <input type="number" name="preco" step="0.01" id="preco" placeholder="Preço (revenda)" required>
                <input type="number" name="quantidade" min="0" id="quantidade" placeholder="Quantidade" required>
                <input type="date" name="validade" id="validade" placeholder="Validade" required>
                <select name="fornecedor" id="fornecedor" required>
                    <?php
                    
                        $sql = "SELECT fornecedor_id, fornecedor_nome FROM fornecedores";
                        $retorno = mysqli_query($link, $sql);

                        while($tbl = mysqli_fetch_array($retorno)){
                    ?>
                            <option value="<?=$tbl[0]?>"><?=$tbl[1]?></option>
                    <?php
                        }
                    ?>
                </select>
                <span id="error"></span>
                <button value="Entrar" onclick="submitForm()">Cadastrar produto</button>
            </div>
        </div>
    </main>
    <script>
        // Carregando eventos ao carregar a DOM
        document.addEventListener('DOMContentLoaded', function() {
            let profile = document.getElementById("profile");
            let details = document.getElementById("details");
            let textarea = document.getElementById("descricao");

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

            textarea.addEventListener('input', function(event) {
                let textNow = this.value;
                if(textNow.length > 70) {
                    textarea.value = textNow.slice(0, 70);
                }
            })
        });

        // Script AJAX que tenta cadastrar o produto e retorna uma resposta
        function submitForm() {
            var nome = document.getElementById('nome').value;
            var descricao = document.getElementById('descricao').value;
            var custo = document.getElementById('custo').value;
            var preco = document.getElementById('preco').value;
            var quantidade = document.getElementById('quantidade').value;
            var validade = document.getElementById('validade').value;
            var fornecedor = document.getElementById('fornecedor').value;
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../functions/product_register.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            
            // Callback a ser executado quando a resposta do servidor for recebida
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    
                    // Se a resposta for "0", exibe um erro (produto já existe)
                    if(response === "0") {
                        document.getElementById('error').style.display = 'none';
                        document.getElementById('error').innerHTML = 'O produto já existe.';
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
            var params = 'nome=' + nome + '&descricao=' + descricao + '&custo=' + custo 
                + '&preco=' + preco + '&quantidade=' + quantidade + '&validade=' + validade 
                + '&fornecedor=' + fornecedor;
            
            xhr.send(params);
        }
    </script>
</body>
</html>