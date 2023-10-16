<?php

$var1 = "Ariel";
$var2 = "Ariel";

# Condicional que verifica SOMENTE igualdade de dados
if ($var1 == $var2){   
    echo("São as mesmas strings");
}
else if ($var1 == "Foguete" or $var2 == "Foguete"){
    echo("Decolando!");
}
else{
    echo("Não são as mesmas strings!");
}

// Quebra de linha
echo("<br>");

# Condicional que verifica igualdade de dados E de igualdade de tipo de dados
# Exemplo: "3" e "3" retorna true
if ($var1 === $var2){
    echo("Mesmo data type");
}
else{
    echo("Data types diferentes");
}

// Quebra de linha
echo("<br>");

# Operador ternário (if recursivo)
# Estrutura -> <condicional> ? <valor se verdadeiro> : <valor se falso>
echo($var1 == $var2 ? "É igual" : "É diferente");

?>