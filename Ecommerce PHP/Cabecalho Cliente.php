<?php

# Conexão com banco
include("Conexão com banco.php");

session_start();
isset($_SESSION['nomeusuario'])?$nomeusuario = $_SESSION['nomeusuario']: "";
isset($_SESSION['idusuario'])?$idusuario = $_SESSION['idusuario']: "";

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
        <li><a href="Loja.php">Loja</a></li>
        <li><a href="Carrinho.php">Carrinho</a></li>
        <li><a href="Registro de compras.php">Registro de compras</a></li>
        <li class="menuloja"><a href="Logout Cliente.php">SAIR</a></li>

        <!--Valida se sessão de usuário está autenticada, senão, retorna para login -->
        <?php
        if($nomeusuario != null) {
        ?>
        <li class="profile"><a href="Perfil.php?id=<?=$idusuario?>">Olá <?= strtoupper($nomeusuario) ?></a></li>
        <?php
        } else {
            echo "<script>window.alert('CLIENTE NÃO AUTENTICADO');
            window.location.href='Login Cliente.php';</script>";
        }
        ?>
    </ul>
</div>