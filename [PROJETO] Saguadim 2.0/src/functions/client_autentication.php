<?php 

// Link de conexão do banco
include('conectadb.php');

// Trata os dados recebidos do formulário com AJAX por meio do método POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Query para validar se o cliente existe
    $sql = "SELECT COUNT(cli_id) FROM clientes 
        WHERE cli_email = '$email' 
        AND cli_senha = '$senha' 
        AND cli_status = 's'";
    $retorno = mysqli_query($link, $sql);
    
    // Registra o log da operação MySQL
    $sql = '"' . $sql . '"';
    $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
        VALUES ($sql, NOW())";
    
    mysqli_query($link, $sqllog);
    
    while ($tbl = mysqli_fetch_array($retorno)){
        $resultado = $tbl[0];
    }
    
    if ($resultado == 0){
        echo("0");
    }
    else{
        $sql = "SELECT * FROM clientes 
        WHERE cli_email = '$email'
        AND cli_senha = '$senha'
        AND cli_status = 's'";
        $retorno = mysqli_query($link, $sql);
    
        // Registra o log da operação MySQL
        $sql = '"' . $sql . '"';
        $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
            VALUES ($sql, NOW())";
        mysqli_query($link, $sqllog);
        
        session_set_cookie_params(60 * 60 * 24 * 30); // Define a duração da sessão para 30 dias
        session_start();
    
        while ($tbl = mysqli_fetch_array($retorno)){
            $_SESSION['tiposessao'] = 'client';
            $_SESSION['idusuario'] = $tbl[0];
            $_SESSION['nomeusuario'] = $tbl[1];
        }
    
        echo("1");
    }
}

exit();

?>