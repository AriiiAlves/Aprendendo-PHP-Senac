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
    <title>Lista de usuários</title>
    <link rel="stylesheet" href="../../../../styles/admin_home.css">
    <link rel="stylesheet" href="../../../../styles/admin_list.css">
</head>
<body>
    <nav>
        <img src="../../../../public/photos/saguadim_logo.png">
        <div class="ul_container">
            <h2>Cadastro</h2>
            <ul>
                <li><a href="../cadastro/user.php">Usuário</a></li> 
                <li><a href="../cadastro/client.php">Cliente</a></li>
                <li><a href="../cadastro/product.php">Produto</a></li>
                <li><a href="../cadastro/supplier.php">Fornecedor</a></li>
                
            </ul>
            <h2>Lista</h2>
            <ul>
                <li><a href="user.php" class="selected">Usuário</a></li> 
                <li><a href="client.php">Cliente</a></li>
                <li><a href="product.php">Produto</a></li>
                <li><a href="supplier.php">Fornecedor</a></li>
            </ul>
            <h2>Encomendas</h2>
            <ul>
                <li><a href="../encomendas/requests.php">Solicitadas</a></li> 
                <li><a href="../encomendas/waiting.php">Aguardando retirada</a></li>
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
        <div class="user">
            <table>
                <th>Login</th>
                <th>Email</th>
                <th>Status</th>
                <th></th>
                <?php
                    // Selecionando nome, email, status e id dos usuários para criar uma tabela
                    $sql = "SELECT usu_login, usu_email, usu_status, usu_id FROM usuarios";
                    $retorno = mysqli_query($link, $sql);

                    while($tbl = mysqli_fetch_array($retorno)){
                ?>
                        <tr>
                            <td><?= $tbl[0] ?></td>
                            <td><?= $tbl[1] ?></td>
                            <td <?= $tbl[2] == 's'?"style='color: green'":"style='color: red'" ?>><?= $tbl[2] == 's'?"Ativo":"Inativo" ?></td>
                            <td>
                                <a href="alterar/change_user.php?id=<?= $tbl[3] ?>">Editar</a>
                                <button onclick="deleteData(<?= $tbl[3] ?>)">Deletar</button>
                            </td>
                        </tr>
                <?php
                    }
                ?>
            </table>
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

    // Script AJAX que tenta excluir um usuário e retorna uma resposta
    function deleteData(usu_id) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../../../functions/delete_data.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        // Callback a ser executado quando a resposta do servidor for recebida
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = xhr.responseText;
                console.log(response);
                // Se a resposta for "0", exibe um erro
                if(response === "0") {
                    window.alert("Ocorreu um erro.")
                }
                // Se a resposta for "1", mostra uma mensagem de sucesso
                else if (response === "1") {
                    window.alert("Usuário excluído com sucesso.")
                    window.location.reload();
                }
            }
        }

        // Converte os dados para a notação de URL
        var params = `usu_id=${usu_id}`;
            
        xhr.send(params);
    }
</script>