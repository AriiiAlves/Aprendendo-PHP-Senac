<?php

// Verifica se há uma sessão ativa
if (session_status() == PHP_SESSION_ACTIVE && !empty(session_id())) {
    // A sessão está ativa, então redireciona para a home
    header("Location: subpages/home/home.html");
} else {
    // Não há sessão ativa, então redireciona para o login
    header("Location: subpages/autentication/login.html");
}

?>