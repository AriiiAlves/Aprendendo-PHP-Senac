<?php
    session_start();//*Inicia a sessão (permite o uso de variáveis de sessão)

    # Não pode haver o cabeçalho aqui, pois não há uma sessão iniciada.
    # As variáveis de conexão com o banco são retiradas diretamente.
    include("Conexão com banco.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nomeusuario'];
        $senha = $_POST['senha'];

        # Confere se o usuário existe
        $sql = "SELECT count(cli_id) FROM clientes WHERE cli_nome = '$nome'";
        $retorno = mysqli_query($link, $sql);
        $tbl = mysqli_fetch_array($retorno);
        if($tbl[0] == 0){
            echo "<script> window.alert('Cliente não cadastrado!'); </script>";
            echo "<script>window.location.href='Login Cliente.php';</script>";
        }
        else{
            # Busca o tempero
            $sql = "SELECT cli_tempero FROM clientes WHERE cli_nome = '$nome'";
            $retorno = mysqli_query($link, $sql);
            $tempero = mysqli_fetch_array($retorno)[0];
            # $tempero = $tbl[0];
    
            # Cria uma hashe md5, concatenando a senha digitada no login com o
            # tempero no banco de dados. Essa hashe deve ser exatamente igual à
            # hashe no campo 'usu_senha' do respectivo usuário.
            $senha = md5($senha . $tempero);
    
            # Conta quantos usuários com 'usu_nome' possuem essa $senha no banco
            # de dados.
            $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha'";
            $retorno = mysqli_query($link, $sql);
            while ($tbl = mysqli_fetch_array($retorno)) {
                $cont = $tbl[0];
            }
    
            # Se houver no mínimo uma pessoa com exatamente esse nome de usuário
            # e exatamente essa senha que é a hashe md5 criada a partir do mesmo
            # princípio utilizado no cadastro do usuário, utilizando-se do campo
            # 'usu_tempero', cria duas variáveis de sessão: 'idusuario' e 'nomeusuario',
            # com o ID e o Nome do usuário.
            #
            # Se não, diz que o usuário ou senha estão incorretos e retorna ao formulário.
            if($cont == 1){
                $sql = "SELECT cli_id, cli_nome FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha' AND cli_ativo = 's'";
                $retorno = mysqli_query($link, $sql);
                while ($tbl = mysqli_fetch_array($retorno)) {
                    $_SESSION['idusuario'] = $tbl[0];
                    $_SESSION['nomeusuario'] = $tbl[1];
                }
                # Manda o usuário para a lista de usuários
                echo "<script> window.location.href='Loja.php'; </script>";
            } else {
                echo "<script> window.alert('Usuário ou senha incorretos!'); </script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/Visão Adm.css">
        <title>Login do Cliente</title>
    </head>
    <body>
        <form action="Login Cliente.php" method="POST">
            <h1>Login do Cliente</h1>
            <input type="text" name="nomeusuario" id="nome" placeholder="Nome">
            <p></p>
            <input type="password" id="senha" name="senha" placeholder="Senha">
            <p></p>
            <input type="submit" name="login" value="LOGIN">
            <p></p>
            <a href="Cadastro Cliente.php" style="text-decoration: none;">Criar uma conta</a><br><br>
            <a href="Esqueci minha senha.php" style="text-decoration: none;">Esqueci minha senha</a>
        </form>
    </body>
</html>