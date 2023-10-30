<?php

# Inicia a conexão com o banco de dados
include("Conexão com banco.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $desc = $_POST['desc'];
    $quant = $_POST['quant'];
    $valor = $_POST['valor'];
    $ativo = $_POST['ativo'];

    $sql = "UPDATE produtos SET pd_nome = '$nome', pd_desc = '$desc', pd_quant = $quant, pd_valor = $valor, pd_ativo = '$ativo' WHERE pd_id = $id";

    # Inserção e criptografia da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
        $tipo = exif_imagetype($_FILES['imagem']['tmp_name']);

        if ($tipo !== false){
            // O arquivo é uma imagem
            $imagem_temp = $_FILES['imagem']['tmp_name'];
            $imagem = file_get_contents($imagem_temp);
            $imagem_base64 = base64_encode($imagem);
        } else{
            // O arquivo não é uma imagem
            $imagem = file_get_contents (".\\Img\\alert.png");
            $imagem_base64 = base64_encode($imagem);
        }
    } else{
        // O arquivo não foi enviado
        $imagem = file_get_contents (".\\Img\\alert.png");
        $imagem_base64 = base64_encode($imagem);
    }

    mysqli_query($link, $sql);

    echo "<script>window.alert('Produto alterado com sucesso!');</script>";
    echo "<script>window.location.href='Lista de Produtos.php';</script>";
}

# Coletando os dados passados via GET
$id = $_GET['id']; # Coletando o ID do produto
$sql = "SELECT * FROM produtos WHERE pd_id = '$id'";
$retorno = mysqli_query($link, $sql);

while($tbl = mysqli_fetch_array($retorno)){
    $nome = $tbl[1]; # Campo Nome
    $desc = $tbl[2]; # Campo Descrição
    $quant = $tbl[3]; # Campo Quantidade
    $valor = $tbl[4]; # Campo Valor
    $img = $tbl[6]; # Campo Imagem
    $ativo = $tbl[5]; # Campo Ativo
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" rel="stylesheet" href="./Css/Cadastro.css">
</head>

<body>
    <div>
        <form action="Altera produto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $id ?>">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= $nome ?>" required>
            <label>Descrição</label>
            <input type="text" name="desc" value="<?= $desc ?>" required>
            <label>Quantidade</label>
            <input type="number" min="0" step="1" name="quant" value="<?= $quant ?>" required>
            <label>Valor</label>
            <input type="number" min="0" step="0.01" name="valor" value="<?= $valor ?>" required>
            <label>Imagem</label><br>
            <img style="display:block; margin:0 auto; margin-top:10px; margin-bottom:10px;" width="150px" height="150px" src="data:image/png;base64,<?= $img ?>">
            <input type="file" name="img">
            <p></p>
            <label>Status: <?= ($ativo == 's') ? "Ativo" : "Inativo" ?></label>
            <p></p>
            <input type="radio" name="ativo" value="s" <?= $ativo == 's' ? "checked" : "" ?>>Ativo<br>
            <input type="radio" name="ativo" value="n" <?= $ativo == 'n' ? "checked" : "" ?>>Inativo<br><br>

            <input type="submit" value="salvar">
        </form>
    </div>
</body>

</html>