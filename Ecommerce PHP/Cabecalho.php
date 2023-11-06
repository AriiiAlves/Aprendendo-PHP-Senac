<?php

# Conexão com banco
include("Conexão com banco.php");

session_start();
isset($_SESSION['nomeusuario'])?$nomeusuario = $_SESSION['nomeusuario']: "";
$nomeusuario = $_SESSION['nomeusuario'];

?>

<!--Olha que interessante: esse arquivo Cabecalho.php não possui uma tag HTML e nem BODY pai,
apenas uma DIV. Ou seja: quando for chamado o include("Cabecalho.php") em algum arquivo.php,
será executado esse código PHP e, caso o usuário esteja logado, a DIV cabeçalho vai aparecer,
como se fosse uma DIV inserida no HTML pai!

Esse controle de login do usuário é feito através de uma variável de sessão. Se ela estiver
preenchida, quer dizer que há um usuário logado, e o código executa normalmente.

Mas caso a variável de sessão esteja vazia, quer dizer que o usuário não está logado, e um 
script em JS manda o usuário de volta para login.php-->

<div>
    <ul class="menu">
        <li><a href="Cadastro Cliente.php">Cadastrar usuário</a></li>
        <li><a href="Lista de Usuarios.php">Lista de usuários</a></li>
        <li><a href="Cadastro Produto.php">Cadastrar produto</a></li>
        <li><a href="Lista de Produtos.php">Lista de produtos</a></li>
        <!-- <li><a href="listacliente.php">LISTAR CLIENTES</a></li>-->
        <li><a href="Loja.php">Loja</a></li>
        <li class="menuloja"><a href="logout.php">SAIR</a></li>

        <!--Valida se sessão de usuário está autenticada, senão, retorna para login -->
        <?php
        if($nomeusuario != null) {
        ?>
        <li class="profile">Olá <?= strtoupper($nomeusuario) ?></li>
        <?php
        } else {
            echo "<script>window.alert('USUÁRIO NÃO AUTENTICADO');
            window.location.href='login.php';</script>";
        }
        ?>
    </ul>
</div>