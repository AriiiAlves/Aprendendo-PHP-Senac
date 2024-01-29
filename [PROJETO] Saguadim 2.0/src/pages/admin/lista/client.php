<?php

include('../../../functions/conectadb.php');
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
    <title>Lista de clientes</title>
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
                <li><a href="user.php">Usuário</a></li> 
                <li><a href="client.php" class="selected">Cliente</a></li>
                <li><a href="product.php">Produto</a></li>
                <li><a href="supplier.php">Fornecedor</a></li>
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
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Curso</th>
                <th>Sala</th>
                <th>Saldo</th>
                <th>Status</th>
                <th></th>
                <?php
                            
                    $sql = "SELECT cli_nome, cli_email, cli_telefone, cli_cpf, cli_curso, cli_sala, cli_saldo, cli_status, cli_id FROM clientes";
                    $retorno = mysqli_query($link, $sql);

                    while($tbl = mysqli_fetch_array($retorno)){
                ?>
                        <tr>
                            <td><?= $tbl[0] ?></td>
                            <td><?= $tbl[1] ?></td>
                            <td><?= $tbl[2] ?></td>
                            <td><?= $tbl[3] ?></td>
                            <td><?= $tbl[4] ?></td>
                            <td><?= $tbl[5] ?></td>
                            <td>R$ <?= number_format($tbl[6], 2, '.') ?></td>
                            <td <?= $tbl[7] === 's'?"style='color: green'":"style='color: red'" ?>><?= $tbl[7] === 's'?"Ativo":"Inativo" ?></td>
                            <td>
                                <a href="alterar/change_client.php?id=<?= $tbl[8] ?>">Editar</a>
                                <button onclick="deleteData(<?= $tbl[8] ?>)">Deletar</button>
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

    // Script AJAX que tenta excluir um cliente e retorna uma resposta
    function deleteData(cli_id) {
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
                    window.alert("Cliente excluído com sucesso.")
                    window.location.reload();
                }
            }
        }

        // Converte os dados para a notação de URL
        var params = `cli_id=${cli_id}`;
            
        xhr.send(params);
    }
</script>