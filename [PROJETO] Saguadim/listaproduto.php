<?php

include("cabecalho.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="cadastraproduto.css">
</head>
<body>
    <div class="table-container">
        <table>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Custo</th>
            <th>Preco</th>
            <th>Quantidade</th>
            <th>Validade</th>
            <th>Fornecedor</th>
            <th>Status</th>
            <?php
                        
                $sql = "SELECT pro_nome, pro_descricao, pro_custo, pro_preco, pro_quantidade, pro_validade, fk_fornecedor_id, pro_status FROM produtos";
                $retorno = mysqli_query($link, $sql);

                while($tbl = mysqli_fetch_array($retorno)){
            ?>
                    <tr>
                        <td><?= $tbl[0] ?></td>
                        <td><?= strlen($tbl[1]) > 30?substr($tbl[1], 0, 30)."... <a class='item' data-details='$tbl[1]'>Ver mais</a>":$tbl[1]; ?></td>
                        <td>R$ <?= $tbl[2] ?></td>
                        <td>R$ <?= $tbl[3] ?></td>
                        <td><?= $tbl[4] ?></td>

                        <?php
                        $dia = substr($tbl[5], 8, 2);
                        $mes = substr($tbl[5], 5, 2);

                        switch($mes){
                            case "01":
                                $mes = "Jan";
                                break;
                            case "02":
                                $mes = "Fev";
                                break;
                            case "03":
                                $mes = "Mar";
                                break;
                            case "04":
                                $mes = "Abr";
                                break;
                            case "05":
                                $mes = "Mai";
                                break;
                            case "06":
                                $mes = "Jun";
                                break;
                            case "07":
                                $mes = "Jul";
                                break;
                            case "08":
                                $mes = "Ago";
                                break;
                            case "09":
                                $mes = "Set";
                                break;
                            case "10":
                                $mes = "Out";
                                break;
                            case "11":
                                $mes = "Nov";
                                break;
                            case "12":
                                $mes = "Dez";
                                break;
                        }

                        $ano = substr($tbl[5], 0, 4);
                        ?>

                        <td><?= $dia . "/" . $mes . "/" . $ano ?></td>

                        <?php
                        $sql = "SELECT fornecedor_nome FROM fornecedores WHERE fornecedor_id = $tbl[6]";
                        $fornecedor = mysqli_fetch_array(mysqli_query($link, $sql))[0];
                        ?>

                        <td><?= $fornecedor ?></td>
                        <td data-status="<?= $tbl[7] == 's'?"Ativo":"Inativo" ?>"></td>
                    </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div class="message" id="message">
        <span class="close-btn" onclick="closeMessage()">X</span>
        <p id="details"></p>
    </div>
</body>
</html>

<script>
        // Função para exibir a mensagem com os detalhes do item
        const showMessage = (details) => {
            const messageBox = document.getElementById('message');
            const detailsElement = document.getElementById('details');

            detailsElement.textContent = details;
            messageBox.style.display = 'block';
        };

        // Função para fechar a mensagem
        const closeMessage = () => {
            document.getElementById('message').style.display = 'none';
        };

        // Adicionar evento de clique para os itens da tabela
        const items = document.querySelectorAll('.item');
        items.forEach(item => {
            item.addEventListener('click', () => {
                const details = item.getAttribute('data-details');
                showMessage(details);
            });
        });
    </script>