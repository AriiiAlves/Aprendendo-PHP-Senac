<?php

# conecta com o servidor (xampp)
$servidor = "127.0.0.1";
# nome do usuário
$usuario = "root";
# senha do usuário
$senha = "";
# nome do banco
$banco = "saguadim";

# link de conexão com o banco
$link = mysqli_connect($servidor, $usuario, $senha, $banco);

?>