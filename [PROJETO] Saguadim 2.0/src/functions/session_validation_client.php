<?php

// Iniciando as variáveis de sessão
session_start();

// Se a sessão estiver inativa ou alguma variável de sessão estiver vazia, retorna o usuário à página de login
if (session_status() != PHP_SESSION_ACTIVE or empty(session_id()) or empty($_SESSION['tiposessao']) or empty($_SESSION['idusuario']) or empty($_SESSION['nomeusuario'])) {
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/login.html");
}
else {
    // Se o tipo de sessão for diferente de cliente, retorna à página de login
    if ($_SESSION['tiposessao'] != 'client') {
        header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/login.html");
    }
}

?>