<?php

// Inicia as variáveis de sessão, e em seguida destrói a sessão existente
session_start(); 
session_destroy(); 
// Redireciona para o index.php, que irá levar o usuário ao login de cliente
header("/%5bPROJETO%5d%20Saguadim%202.0/index.php");

?>