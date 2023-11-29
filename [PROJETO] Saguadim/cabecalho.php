<?php

# Conexão com banco
include("conectadb.php");

session_start();
isset($_SESSION['nomeusuario'])?$nomeusuario = $_SESSION['nomeusuario']: "";
isset($_SESSION['idusuario'])?$idusuario = $_SESSION['idusuario']: "";

?>

<div class="header">
    <ul class="menu">
        <li><a href="cadastrausuario.php">Cadastrar usuário</a></li>
        <li><a href="listausuario.php">Usuários</a></li>
        <li><a href="cadastraproduto.php">Cadastrar produto</a></li>
        <li><a href="listaproduto.php">Produtos</a></li>
        <li><a href="cadastrafornecedor.php">Cadastrar fornecedor</a></li>
        <li><a href="listafornecedor.php">Fornecedores</a></li>
        <li><a href="#.php">Clientes</a></li>
        <li><a href="#.php">Encomendas</a></li>

        <li class="profile"><a href="logout.php">Sair</a></li>

        <!--Valida se sessão de usuário está autenticada, senão, retorna para login -->
        <?php
        if($nomeusuario != null) {
        ?>
        <li class="profile" id="nome"><a href="#.php?id=<?=$idusuario?>"><?= strtoupper($nomeusuario) ?></a></li>
        <?php
        } else {
            echo "<script>window.alert('Cliente não autenticado!');
            window.location.href='login.html';</script>";
        }
        ?>
    </ul>
</div>