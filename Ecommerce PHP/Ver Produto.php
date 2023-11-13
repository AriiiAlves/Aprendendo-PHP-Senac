<?php

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $nomeproduto = $_POST['nomeproduto'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $quantidade = (int)$quantidade; # Converte para int, caso necessário
    $preco = $_POST['preco'];
    $preco = (float)$preco;
    $totalitem = ($preco);

    # Gera um random para definir um carrinho único e exclusivo
    $numerocarrinho = ($idusuario . RAND());

    # Validação Cliente logado

    if($idusuario <= 0){
        echo "<script>window.alert('Você precisa fazer login para adicionar algum item ao carrinho!')</script>";
        echo "<script>window.location.href='Loja.php'</script>";
    }else{
        # Verifica se existe um carrinho já aberto
        $sql = "SELECT COUNT (car_id) FROM carrinho INNER JOIN clientes ON fk_cli_id = cli_id WHERE cli_id = $idusuario AND car_finalizado = 'n'";
        $retorno = mysqli_query($link, $sql);

        # Se o carrinho não existe cria um novo carrinho
        while($tbl = mysqli_fetch_array($retorno)){
            $cont = $tbl[0];

            if ($cont == 0){
                $valor_venda = $quantidade * $preco;

                # Se o carrinho não existe gera um novo carrinho e insere na tabela item_carrinho
                $sql = "INSERT INTO carrinho(car_id, car_valorvenda, fk_cli_id, car_finalizado)
                VALUES ('$numerocarrinho', $valor_venda, $idusuario, 'n')";
                mysqli_query($link, $sql);

                # Insere o item no carrinho
                $sql = "INSERT INTO item_carrinho (fk_car_id, fk_pro_id, car_item_quantidade)";
                mysqli_query($link, $sql);

                $_SESSION['carrinhoid'] = $numerocarrinho;

                echo "<script>window.alert('Produto adicionado ao carrinho $numerocarrinhocliente')</script>";
                echo "<script>window.location.href='Loja.php'</script>";
            }
            else{
                # Se o carrinho existe, consulta o número do carrinho para adicionar mais itens
                $sql = "SELECT car_id FROM carrinho WHERE fk_cli_id = $idusuario AND car_finalizado = 'n'";
                $retorno = mysqli_query($link, $sql);

                $numerocarrinhocliente = mysqli_fetch_array($retorno)[0];
                $_SESSION['carrinhoid'] = $numerocarrinhocliente;
            }
        }
    }
}

?>

<div class="formulario">
    <form class="visualizaproduto" action="Ver Produto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id ?>" readonly>
        <label>Nome</label>
        <input type="text" name="nomeproduto" id="nome" value="<?= $nomeproduto ?>" readonly>
        <label>Descrição</label>
        <textarea name="descricao" readonly><?= $descricao ?></textarea>
        <label>Quantidade</label>
        <input type="number" name="quantidade" id="quantidade" min="1" value="1">
        <label>Preço</label>
        <input type="decimal" name="preco" id="preco" value="R$ <?= $preco ?>" readonly>
        <input type="submit" value="Adicionar ao carrinho">
    </form>
</div>
<div style="position: relative;">
    <a href="favoritar.php?id=<?= $id ?>" style="position: absolute; top: 0; left: 0;">
        <img src="<?php echo $coracao; ?>" width="50" height="50">
    </a>
    <td>
        <img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual ?>">
    </td>
</div>