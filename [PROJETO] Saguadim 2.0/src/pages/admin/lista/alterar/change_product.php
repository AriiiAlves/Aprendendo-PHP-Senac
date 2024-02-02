<?php

include('../../../../functions/conectadb.php');
include('../../../../functions/session_validation_user.php');

if (isset($_POST['sair'])) {
    // Destrói todas as variáveis de sessão
    session_unset();

    // Destroi a sessão
    session_destroy();

    // Redireciona para o index.php
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/index.php");
    exit();
}

$pro_id = $_GET['id'];

$sql = "SELECT * FROM produtos WHERE pro_id = $pro_id";
$retorno = mysqli_query($link, $sql);

while($tbl = mysqli_fetch_array($retorno)) {
    $pro_id = $tbl[0];
    $nome = $tbl[1];
    $descricao = $tbl[2];
    $custo = $tbl[3];
    $preco = $tbl[4];
    $quantidade = $tbl[5];
    $validade = $tbl[6];
    $fornecedor_id = $tbl[7];
    $status = $tbl[8];
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
                <li><a href="../../cadastro/client.php">Cliente</a></li>
                <li><a href="../../cadastro/product.php" class="selected">Produto</a></li>
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
        <div class="container client edit_product">
            <div>
                <label>Nome do produto</label>
                <input type="text" name="nome" id="nome" placeholder="Nome do produto" value="<?= $nome ?>" required>
                <label>Descrição</label>
                <textarea name="descricao" rows="5" id="descricao" placeholder="Descrição" required><?= $descricao ?></textarea>
                <label>Custo (valor)</label>
                <input type="number" name="custo" step="0.01" id="custo" placeholder="Custo (valor)" value="<?= $custo ?>" required>
                <label>Preço (revenda)</label>
                <input type="number" name="preco" step="0.01" id="preco" placeholder="Preço (revenda)" value="<?= $preco ?>" required>
                <label>Quantidade</label>
                <input type="number" name="quantidade" min="0" id="quantidade" placeholder="Quantidade" value="<?= $quantidade ?>" required>
                <label>Validade</label>
                <input type="date" name="validade" id="validade" placeholder="Validade" value="<?= $validade ?>" required>
                <label>Fornecedor</label>
                <select name="fornecedor" id="fornecedor_id" required>
                    <?php
                    
                        $sql = "SELECT fornecedor_id, fornecedor_nome FROM fornecedores";
                        $retorno = mysqli_query($link, $sql);

                        while($tbl = mysqli_fetch_array($retorno)){
                            if ($tbl[0] === $fornecedor_id) {
                    ?>
                            <option value="<?=$tbl[0]?>" selected><?=$tbl[1]?></option>
                    <?php
                            } else {
                    ?>
                            <option value="<?=$tbl[0]?>"><?=$tbl[1]?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
                <label>Status</label>
                <input type="radio" name="status" id="status_ativo" value="s" required <?= $status === 's' ? 'checked' : '' ?>>
                <label class="radio">Ativo</label>
                <input type="radio" name="status" id="status_inativo" value="n" required <?= $status === 'n' ? 'checked' : '' ?>>
                <label class="radio">Inativo</label>
                <span id="error"></span>
                <button value="Entrar" onclick="submitForm()">Editar produto</button>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-masker/1.1.0/vanilla-masker.min.js"></script>
    <script>
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
            var nome = document.getElementById('nome').value;
            var descricao = document.getElementById('descricao').value;
            var custo = document.getElementById('custo').value;
            var preco = document.getElementById('preco').value;
            var quantidade = document.getElementById('quantidade').value;
            var validade = document.getElementById('validade').value;
            var fornecedor_id = document.getElementById('fornecedor_id').value;
            
            if (document.getElementById('status_ativo').checked) {
                var status = 's';
            }
            else if(document.getElementById('status_inativo').checked) {
                var status = 'n';
            }
        
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../../../../functions/change_product.php', true);
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
                        window.alert("Produto editado com sucesso!")
                    }
                }
            };
        
            // Converte os dados para a notação de URL
            var params = 'pro_id=' + <?= $pro_id ?> + '&nome=' + nome + '&descricao=' + descricao + '&custo=' + custo 
                + '&preco=' + preco + '&quantidade=' + quantidade + '&validade=' + validade 
                + '&fornecedor_id=' + fornecedor_id + '&status=' + status;

            xhr.send(params);
        }
    </script>
</body>
</html>