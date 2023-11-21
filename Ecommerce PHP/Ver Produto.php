<?php

include("Cabecalho Cliente.php");

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
    $numerocarrinho = ($idusuario . RAND(1000, 9999) . RAND(1000, 9999));
    

    $sql = "SELECT COUNT(car_id) FROM carrinho WHERE car_id = $numerocarrinho";

    while (mysqli_fetch_array(mysqli_query($link, $sql))[0] > 0){
        # Gera um random para definir um carrinho único e exclusivo
        $numerocarrinho = ($idusuario . RAND(1000, 9999) . RAND(1000, 9999));
        $sql = "SELECT COUNT(car_id) FROM carrinho WHERE car_id = $numerocarrinho";
        echo("loop ");
    }

    # Validação Cliente logado

    if($idusuario <= 0){
        echo "<script>window.alert('Você precisa fazer login para adicionar algum item ao carrinho!')</script>";
        echo "<script>window.location.href='Loja.php'</script>";
    }else{
        # Verifica se existe um carrinho já aberto
        $sql = "SELECT COUNT(car_id) FROM carrinho INNER JOIN clientes ON fk_cli_id = cli_id WHERE cli_id = $idusuario AND car_finalizado = 'n'";
       // echo(" " . $sql . "<br>");
        $retorno = mysqli_query($link, $sql);

        # Se o carrinho não existe cria um novo carrinho
        while($tbl = mysqli_fetch_array($retorno)){
            $cont = $tbl[0];

            if ($cont == 0){
                $valor_venda = $quantidade * $preco;
                
                # Se o carrinho não existe gera um novo carrinho e insere na tabela item_carrinho
                $sql = "INSERT INTO carrinho(car_id, car_valorvenda, fk_cli_id, car_finalizado)
                VALUES ($numerocarrinho, $valor_venda, $idusuario, 'n')";
                echo(" " . $sql);
                mysqli_query($link, $sql);

                # Insere o item no carrinho
                $sql = "INSERT INTO item_carrinho (fk_car_id, fk_pro_id, car_item_quantidade)
                VALUES ($numerocarrinho, $id, $quantidade)";
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

                # Verifica se já existe esse item no carrinho
                $sql = "SELECT car_item_quantidade FROM item_carrinho WHERE fk_car_id = $numerocarrinhocliente AND fk_pro_id = $id";
                $retorno = mysqli_query($link, $sql);
                $quant_atual = mysqli_fetch_array($retorno);

                if($retorno){
                    # Se existe, atualiza a quantidade
                    if (mysqli_num_rows($retorno) >= 1){
                        $sql = "UPDATE item_carrinho SET car_item_quantidade = ($quantidade + $quant_atual[0]) WHERE fk_car_id = $numerocarrinhocliente AND fk_pro_id = $id";
                        mysqli_query($link, $sql);
                        echo "<script>window.alert('Produto adicionado ao carrinho $numerocarrinhocliente')</script>";
                        echo "<script>window.location.href='Loja.php'</script>";
                    }
                    # Se não existe, adiciona o novo item
                    else{
                        $sql = "INSERT INTO item_carrinho (fk_car_id, fk_pro_id, car_item_quantidade) VALUES($numerocarrinhocliente, $id, $quantidade)";
                        mysqli_query($link, $sql);
                        echo "<script>window.alert('Produto adicionado ao carrinho $numerocarrinhocliente')</script>";
                        echo "<script>window.location.href='Loja.php'</script>";
                    }
                }
            }
        }
    }
    echo "<script>window.location.href='Loja.php'</script>";
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM produtos where pd_id = $id";
$retorno = mysqli_query($link, $sql);

while ($tbl = mysqli_fetch_array($retorno)){
    $id = $tbl[0];
    $nomeproduto = $tbl[1];
    $descricao = $tbl[2];
    $preco = $tbl[4];
    $imagem_atual = $tbl[6];
}

# Coração dos favoritos
if (isset($idusuario)){
    $sql = "SELECT COUNT(fav_id) FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
    $retorno = mysqli_query($link, $sql);

    while($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];
        if($cont <= 0){
            $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-rouge.png";
        }
        else{
            $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-rouge-1.png";
        }
    }
} else{
    $coracao = "https://icones.pro/wp-content/uploads/2021/02/icone-de-coeur-rouge.png";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/Visão Adm.css">
        <title><?= $nomeproduto ?></title>
    </head>
    <body>
        <div>
            <a href="Favoritar.php?id=<?= $id ?>" style="position: absolute; top: 0; left: 0; margin-top:50px; margin-left:10px">
                <img src="<?php echo $coracao; ?>" width="50" height="50">
            </a>
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
            <div style="position: relative; margin-top:10px;">
                <td>
                    <img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual ?>">
                </td>
            </div>
        </div>
    </body>
</html>