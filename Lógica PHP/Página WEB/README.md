# Página WEB com PHP

Nessa página, há dois inputs, que recebem duas entradas de números, e um input do type `submit` para enviar a requisição com o método especificado no formulário:  
```html
    <form action="pagina.php" method="post">
        <label>DIGITE UM NUMERO</label>
        <input type="number" name="numero1">
        <br>
        <label>DIGITE OUTRO NUMERO</label>
        <input type="number" name="numero2">
        <br>
        <label>O RESULTADO É: <?=$numero1 + $numero2?></label>
        <br>
        <input type="submit" value="SOMAR">
    </form>
```

O código PHP declara os inputs recebidos como variáveis que podem ser utilizadas no código HTML:  
```php
    <?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        # Se os 2 inputs foram preenchidos, os 2 são declarados com os valores recebidos pelo método POST.
        if (is_numeric($_POST['numero1']) && is_numeric($_POST['numero2'])){
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
        }
        # Se o valor vazio é 'numero2', ele é declarado como 0.
        else if (is_numeric($_POST['numero1'])){
            $numero1 = $_POST['numero1'];
            $numero2 = 0;
        }
        # Se o valor vazio é 'numero1', ele é declarado como 0.
        else if (is_numeric($_POST['numero2'])){
            $numero1 = 0;
            $numero2 = $_POST['numero2'];
        }
        # Se os dois valores são vazios, ambos são declarados como 0.
        else{
            $numero1 = 0;
            $numero2 = 0;
        }
    }

    ?>
```

**Nota**: Sempre é executado primeiro o HTML e CSS. O PHP só é executado ao clicar-se no input `type="submit"`, que executa o script PHP referenciado no formulário `action="pagina.php"`