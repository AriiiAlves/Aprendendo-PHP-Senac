# Estruturas condicionais

## **Estrutura normal**
```php
    $n1 = 1;
    $n2 = 2;

    // Estrutura condicional padrão
    if ($n1 == $n2){
        echo("As variáveis são iguais")
    }
    else{
        echo("As variáveis são diferentes")
    }
```

## **Com operador ternário**

Estrutura do operador ternário: `<condicional> ? <valor se verdadeiro> : <valor se falso>`
```php
    // Com operador ternário
    echo($var1 == $var2 ? "As variáveis são iguais" : "As variáveis são diferentes");
```

## **Switch**

Substitui uma série de declarações `if` e `else if`. O case `default` sempre corresponde a tudo que não foi correspondido pelos outros cases.

```php
    // switch
$num = 1;
switch($num){
    case 1:
        echo 'O número é 1.';
        break;
    case 2:
        echo 'O número é 2.';
        break;
    case 3:
        echo 'O número é 3.';
        break;
    default:
        echo 'Digite um número válido entre 1 e 3.';
        break;
}
```

