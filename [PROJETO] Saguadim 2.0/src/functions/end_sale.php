<?php

session_start();
include('conectadb.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $codigo_venda = $_SESSION['codigo_venda'];

    // Registrar encomenda
}