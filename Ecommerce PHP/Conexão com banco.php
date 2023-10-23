<?php

# conecta com o servidor (xampp)
$servidor = "127.0.0.1";
# nome do usuário
$usuario = "adm";
# senha do usuário
$senha = "123";
# nome do banco
$banco = "ecommerce_ariel";

# link de conexão com o banco
$link = mysqli_connect($servidor, $usuario, $senha, $banco);

?>