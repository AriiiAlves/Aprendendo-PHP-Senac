<?php

# Inicia a conexão com o banco de dados
include("Conexão com banco.php");

# função para retornar erros de entrada
# retorna False se houver erros, e True se não houver
function verificarEntrada($nome_entry, $desc_entry, $quant_entry, $valor_entry){
    # verifica se $nome está vazio
    if($nome_entry == ''){
        $erro = 'Nome do produto vazio';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $nome contém somente espaços
    $cont = 0;
    for ($i = 0; $i < strlen($nome_entry); $i++) {
        $char = substr($nome_entry, $i, 1);
        if($char == ' '){
            $cont += 1;
        }
    }
    if($cont == strlen($nome_entry)){
        $erro = 'O nome do produto não pode conter somente espaços.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $entry está vazio
    if($desc_entry == ''){
        $erro = 'Descrição vazia.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $entry contém somente espaços
    $cont = 0;
    for ($i = 0; $i < strlen($desc_entry); $i++) {
        $char = substr($desc_entry, $i, 1);
        if($char == ' '){
            $cont += 1;
        }
    }
    if($cont == strlen($desc_entry)){
        $erro = 'A descrição não pode conter somente espaços.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $quantidade é vazio
    if(empty($quant_entry)){
        $erro = 'Quantidade não pode ser vazio.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $valor é vazio
    if(empty($valor_entry)){
        $erro = 'Valor não pode ser vazio.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # se não houver erros
    return(True);
}

# Coleta de variáveis via formulário de HTML
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor = str_replace(",", ".", $_POST['valor']);

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

    if(verificarEntrada($nome, $descricao, $quantidade, $valor)){
        $query = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome'";
        $retorno_da_query = mysqli_query($link, $query);
        while ($array = mysqli_fetch_array($retorno_da_query)){
            $cont = $array[0];
        }

        if ($cont > 0){
            echo "<script> window.alert('Produto já cadastrado!'); </script>";
        } else{

            # CORRIGIR: a página trava quando coloca o b64 da imagem

            $query = "INSERT INTO produtos(pd_nome, pd_desc, pd_quant, pd_valor, pd_img, pd_ativo) VALUES('$nome', '$descricao', '$quantidade', '$valor', '$imagem_base64', 'n')";
            mysqli_query($link, $query);
            echo "<script> window.alert('Produto cadastrado com sucesso!'); </script>";
            echo "<script> window.location.href='Cadastro Produto.php'; </script>";
        }
    } else{
        echo "<script> window.location.href='Cadastro Produto.php'; </script>";
    }
}

?>

<html>
    <head>
        <link rel="stylesheet" href="./Css/Cadastro.css">
        <title> Cadastro de produto </title>
    </head>
    <body>
        <div>
            <form action="Cadastro Produto.php" method="post" enctype="multipart/form-data">
                <h1>Cadastro de produto</h1>
                <p>Nome</p>
                <input type="text" name="nome" id="nome" placeholder="Nome do produto">
                <p>Descrição</p>
                <input type="text" name="descricao" id="descricao" placeholder="Descrição">
                <p>Quantidade</p>
                <input type="number" min="0" name="quantidade" min="0" id="quantidade" placeholder="Quantidade">
                <p>Valor (R$)</p>
                <input type="number" step="0.01" min="0" name="valor" id="valor" placeholder="Valor">
                <p>Imagem</p>
                <input type="file" name="imagem" id="imagem" placeholder="Imagem">
                <p></p>
                <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
                <p></p>
            </form>
        </div>
    </body>
</html>