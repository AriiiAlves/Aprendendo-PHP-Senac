<?php

// Crie um código php que valide o alistamento militar obrigatório
// lembrando que é +18 e masculino

$idade = $_GET["idade"] ?? 18;
$sexo = $_GET["sexo"] ?? "masculino";

echo("Sua idade: $idade" . "<br>" . "Seu sexo: $sexo" . "<br>");

if($idade >= 18 and $sexo == "masculino"){
    echo("Bem vindo ao alistamento!");
}
else if($idade >= 18 and $sexo == "feminino"){
    echo("Seu alistamento não é obrigatório (sexo: feminino).");
}
else{
    echo("Você não pode se alistar (permitido somente maiores de 18 anos)");
}

?>