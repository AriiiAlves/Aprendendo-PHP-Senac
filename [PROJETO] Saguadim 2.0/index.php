<?php

// Verifica se há uma sessão ativa
if (session_status() == PHP_SESSION_ACTIVE && !empty(session_id())) {
    // A sessão está ativa, então redireciona para a home
    header("Location: src/pages/user/home.html");
} else {
    // Não há sessão ativa, então redireciona para o login
    header("Location: src/pages/user/login.html");
}

?>