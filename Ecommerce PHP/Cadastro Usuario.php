<?php

include("Cabecalho.php");
# include("Conexão com banco.php");

# função para retornar erros de entrada
# retorna False se houver erros, e True se não houver
function verificarEntrada($nome_entry, $senha_entry)
{
    # verifica se $nome está vazio
    if ($nome_entry == '') {
        $erro = 'Nome de usuário vazio';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $nome contém somente espaços
    $cont = 0;
    for ($i = 0; $i < strlen($nome_entry); $i++) {
        $char = substr($nome_entry, $i, 1);
        if ($char == ' ') {
            $cont += 1;
        }
    }
    if ($cont == strlen($nome_entry)) {
        $erro = 'O nome de usuário não pode conter somente espaços.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $senha está vazia
    if ($senha_entry == '') {
        $erro = 'Senha vazia';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $senha contém a quantidade de caracteres mínimos
    if (strlen($senha_entry) < 6) {
        $erro = 'Sua senha deve conter no mínimo 6 caracteres.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    # verifica se $senha possui os caracteres mínimos
    $temLetra = False;
    $temNum = False;
    for ($i = 0; $i < strlen($senha_entry); $i++) {
        $char = substr($senha_entry, $i, 1);
        if ($temLetra == False) {
            if (ctype_alpha($char)) {
                $temLetra = True;
            }
        }
        if ($temNum == False) {
            if (is_numeric($char)) {
                $temNum = True;
            }
        }
        if ($temNum and $temLetra) {
            break;
        }
    }
    if ($temLetra == False) {
        $erro = 'Sua senha deve conter pelo menos uma letra.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }
    if ($temNum == False) {
        $erro = 'Sua senha deve conter pelo menos um número.';
        echo "<script> window.alert('$erro'); </script>";
        return (False);
    }

    # se não houver erros
    return (True);
}

# Coleta de variáveis via formulário de HTML
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if (verificarEntrada($nome, $senha)) {
        # Passando instruções SQL para o banco
        # Validando se o usuário já existe
        $query = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome'";
        $retorno_da_query = mysqli_query($link, $query);
        while ($array = mysqli_fetch_array($retorno_da_query)) {
            $cont = $array[0];
        }

        # Se o usuário já existe, retorna uma mensagem ao usuário. Se não, cadastra o usuário.
        if ($cont > 0) {
            echo "<script> window.alert('Usuário já cadastrado!'); </script>";
        } else {
            # O tempero é uma concatenação de um número inteiro aleatório (pode ser grande ou pequeno) 
            # com a data atual no formato "HH:MM:SS" (hora, minuto, segundo). Exemplo: 47982314:42:27.
            
            # Depois, é criado um md5 a partir dessa string gerada.
            $tempero = md5(rand() . date('H:i:s'));

            # A senha é outra hash md5 criada a partir da senha criada pelo usuário  
            # concatenada com o tempero (hash md5 gerada com número aleatório + HH:MM:SS)
            # ou seja: $senha . $tempero
            $senha = md5($senha . $tempero);

            # São inseridos os campos no banco de dados
            $query = "INSERT INTO usuarios(usu_nome, usu_senha, usu_ativo, usu_tempero) VALUES('$nome', '$senha', 'n', '$tempero')";
            mysqli_query($link, $query);
            echo "<script> window.alert('Usuário cadastrado com sucesso!'); </script>";
            echo "<script> window.location.href='Cadastro Usuario.php'; </script>";
        }
    } else {
        echo "<script> window.location.href='Cadastro Usuario.php'; </script>";
    }
}

?>

<html lang="pt-br">

<head>
    <link rel="stylesheet" href="./Css/Visão Adm.css">
    <title> Cadastro de usuário </title>
</head>

<body>
    <div>
        <form action="Cadastro Usuario.php" method="post">
            <h3>Cadastro de Usuário</h3>
            <input type="text" name="nome" id="nome" placeholder="Nome de usuário">
            <p></p>
            <input type="password" name="senha" id="senha" placeholder="Senha">
            <span id="MostraSenha" onclick="MostraSenha()" style="cursor:pointer;">👁️</span>
            <p></p>
            <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
            <p></p>
        </form>
    </div>
</body>

</html>

<script>
    function MostraSenha(){
        var passwordInput = document.getElementById("senha");
        var passwordIcon = document.getElementById("MostraSenha");

        if(passwordInput.type == "password"){
            passwordInput.type = "text";
            passwordIcon.textContent = "🙈";
        }
        else{
            passwordInput.type = "password";
            passwordIcon.textContent = "👁️";
        }
    }
</script>