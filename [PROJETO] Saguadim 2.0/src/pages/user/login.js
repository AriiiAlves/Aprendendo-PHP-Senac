function verifyLogin() {
    const xmlhttp = new XMLHttpRequest();
    const dados = {
        "email": "12345@123.com",
        "senha": 1234
    }

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 201) {
            console.log(this.responseText);
            if (this.responseText == "true") {
                window.alert('resposta true');
                window.location.href("../home/home.php")
            }
            else if (this.responseText == "false"){
                window.alert('Usuário ou senha não correspondem.');
            }
            else {
                window.alert('Erro desconhecido.');
            }
        }
    }
    xmlhttp.open("POST", "login.php");
    xmlhttp.send(dados);
}

