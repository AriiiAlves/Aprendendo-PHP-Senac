<?php

include("Conexão com banco.php");

# função para retornar erros de entrada
# retorna False se houver erros, e True se não houver
function verificarEntrada($nome_entry, $senha_entry)
{
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
    $cpf = $_POST['cpf'];
    $datanasc = $_POST['datanasc'];
    $telefone = $_POST['telefone'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (verificarEntrada($nome, $senha)) { 
        # Passando instruções SQL para o banco
        # Validando se o usuário já existe
        $query = "SELECT COUNT(cli_id) FROM clientes WHERE cli_email = '$email'";
        $retorno_da_query = mysqli_query($link, $query);
        while ($array = mysqli_fetch_array($retorno_da_query)) {
            $cont = $array[0];
        }

        # Se o usuário já existe, retorna uma mensagem ao usuário. Se não, cadastra o usuário.
        if ($cont > 0) {
            echo "<script> window.alert('Cliente já cadastrado!'); </script>";
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
            $query = "INSERT INTO clientes(cli_nome, cli_cpf, cli_datanasc, cli_telefone,
             cli_logradouro, cli_numero, cli_cidade, cli_email, cli_senha, cli_ativo,
              cli_tempero, cli_recupera) VALUES('$nome', $cpf, '$datanasc', $telefone, '$logradouro',
              '$numero', '$cidade', '$email', '$senha', 's', '$tempero', 000000)";
            mysqli_query($link, $query);
            echo "<script> window.alert('Cliente cadastrado com sucesso!'); </script>";
            echo "<script> window.location.href='Cadastro Cliente.php'; </script>";
        }
    } else {
        echo "<script> window.location.href='Loja.php'; </script>";
    }
}

?>

<html lang="pt-br">

<head>
    <link rel="stylesheet" href="./Css/Visão Adm.css">
    <title> Cadastro de Cliente </title>
</head>

<body>
    <div>
        <form action="Cadastro Cliente.php" method="post">
            <h3>Cadastro</h3>
            <input type="text" name="nome" id="nome" placeholder="Nome Completo" required>
            <p></p>
            <input type="number" name="cpf" id="cpf" placeholder="CPF" required min="10000000000" max="99999999999">
            <p></p>
            <input type="date" name="datanasc" id="datanasc" placeholder="Data de Nascimento" required>
            <p></p>
            <input type="number" name="telefone" id="telefone" placeholder="Telefone com DDD" min="0" max="99999999999" required>
            <p></p>
            <input type="text" name="logradouro" id="logradouro" placeholder="Logradouro (Rua, Avenida)" required>
            <p></p>
            <input type="text" name="numero" id="numero" placeholder="Número" required>
            <p></p>
            <input type="text" name="cidade" id="cidade" placeholder="Cidade" required>
            <p></p>
            <input type="text" name="email" id="email" placeholder="Email" required>
            <p></p>
            <input type="password" name="senha" id="senha" placeholder="Definir Senha" required>
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