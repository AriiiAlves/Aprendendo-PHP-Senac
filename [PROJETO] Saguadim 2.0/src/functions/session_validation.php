<?php

session_start();

if (session_status() != PHP_SESSION_ACTIVE or empty(session_id()) or empty($_SESSION['tiposessao']) or empty($_SESSION['idusuario']) or empty($_SESSION['nomeusuario'])) {
    header("Location: /%5bPROJETO%5d%20Saguadim%202.0/src/pages/client/login.html");
}

?>