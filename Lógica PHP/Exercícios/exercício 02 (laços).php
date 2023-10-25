<?php

function Sequencia($par, $inicio, $fim){
    if($inicio < $fim){
        for ($i=$inicio; $i <= $fim; $i++){
            if ($i % 2 == 0 && $par == true){
                $lista[] = $i;
            }
            else if ($i % 2 != 0 && $par == false){
                $lista[] = $i;
            }
        }
    }
    else{
        for ($i=$inicio; $i >= $fim; $i--){
            if ($i % 2 == 0 && $par == true){
                $lista[] = $i;
            }
            else if ($i % 2 != 0 && $par == false){
                $lista[] = $i;
            }
        }
    }
    
    foreach($lista as $num){
        echo("| $num |");
    }
}

# 1. Usando laços de repetição crie uma sequência numérica de números Pares em linha de 0 - 500

Sequencia(true, 0, 500);

echo("<br><br>");

# 2. Usando laços de repetição crie uma sequência numérica de ímpares em linha de 500 - 0

Sequencia(false, 500, 0);

?>
