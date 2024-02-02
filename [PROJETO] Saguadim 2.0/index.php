<?php

// Esse script não está funcionando como deveria, pois ao realizar o login, as variáveis
// de sessão preenchidas aparentemente são ao fechar a aba ou o navegador.
// Talvez seja necessário estudar a possibilidade de realizar isso com cookies.
if (session_status() == PHP_SESSION_ACTIVE && !empty(session_id())) {
    // A sessão está ativa, então redireciona para a home
    if($_SESSION['tiposessao'] === 'user') {
        // Se for usuário, redireciona para a home do admin (usuário)
        header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/admin/home.php");
    }
    else if ($_SESSION['tiposessao'] === 'client'){
        // Se for usuário, redireciona para a home do cliente
        header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/home.php");
    }
} else {
    // Não há sessão ativa, então redireciona para o login
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/login.html");
}

?>