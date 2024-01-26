<?php

if (session_status() == PHP_SESSION_ACTIVE && !empty(session_id())) {
    // A sessão está ativa, então redireciona para a home
    if($_SESSION['tiposessao'] === 'user') {
        header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/admin/home.php");
    }
    else if ($_SESSION['tiposessao'] === 'client'){
        header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/home.php");
    }
} else {
    // Não há sessão ativa, então redireciona para o login
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/login.html");
}

?>