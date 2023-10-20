# Laços de repetição

## **For**

```php
    for ($i = 0; $i < 10; $i++){
        echo "$i ";
    }
```  
Saída: `0 1 2 3 4 5 6 7 8 9`

## **While**

```php
    $i = 0;
    while ($i < 10){
        echo "$i ";
        $i++;
    }
```  
Saída: `0 1 2 3 4 5 6 7 8 9`

## **Do While**

Garante que o bloco será executado pelo menos uma vez, mesmo se a condição inicial for falsa.

```php
    $i = 4;
    do{
        echo "$i ";
        $i++;
    }
    while ($i < 10);
```  
Saída: `4 5 6 7 8 9`

Outro exemplo:

```php
    $i = 4;
    do{
        echo "$i ";
        $i++;
    }
    while ($i = "Texto");
```  
Saída: `4`
