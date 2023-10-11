<?php

// Tipos de dados (string, int, float, double)

$nome = "Ariel Alves"; // Str
$idade = 17; // Int
$altura = 1.70; // Double ou float
$verdadeiro = true; // Bool
$falso = false; // Bool

############################### EXERCÍCIO ###############################
// 1 - Imprima todos os valores na tela contendo seus dados (pule linha)

echo("Nome: " . $nome . "<br>");
echo("Idade: " . $idade . "<br>");
echo("Altura: " . number_format($altura, 2, ',', '.') . "<br>"); // number format: formata números
echo("Verdadeiro: " . $verdadeiro . "<br>");
echo("Falso: " . $falso . "<br>");

?>