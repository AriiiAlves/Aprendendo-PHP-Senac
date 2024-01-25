<?php 

function login() {

    // Link de conexão do banco
    $link = mysqli_connect("127.0.0.1", "root", "1234", "saguadim");

    // Trata os dados recebidos do formulário com AJAX por meio do método POST
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        // Query para validar se o usuário existe
        $sql = "SELECT COUNT(usu_id) FROM usuarios 
            WHERE usu_email = '$email' 
            AND usu_senha = '$senha' 
            AND usu_status = 's'";
        $retorno = mysqli_query($link, $sql);
        
        // Gravação de log
        $sql = '"' . $sql . '"';
        $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
            VALUES ($sql, NOW())";
        
        mysqli_query($link, $sqllog);
        
        while ($tbl = mysqli_fetch_array($retorno)){
            $resultado = $tbl[0];
        }
        
        if ($resultado == 0){
            echo "
            <script>
                document.getElementById('error').innerHTML = 'Credenciais incorretas!';
            </script>";
        }
        else{
            $sql = "SELECT * FROM usuarios 
            WHERE usu_email = '$email'
            AND usu_senha = '$senha'
            AND usu_status = 's'";
            $retorno = mysqli_query($link, $sql);
        
            // Gravação de log
            $sql = '"' . $sql . '"';
            $sqllog = "INSERT INTO tab_log (tab_query, tab_data)
                VALUES ($sql, NOW())";
            mysqli_query($link, $sqllog);
            
            session_set_cookie_params(60 * 60 * 24 * 30); // Define a duração da sessão para 30 dias
            session_start(); // Inicia a sessão
        
            while ($tbl = mysqli_fetch_array($retorno)){
                $_SESSION['idusuario'] = $tbl[0];
                $_SESSION['nomeusuario'] = $tbl[1];
            }
        
            echo "<script>window.location.href('../home/home.html')</script>";
        }
    }
}

?>