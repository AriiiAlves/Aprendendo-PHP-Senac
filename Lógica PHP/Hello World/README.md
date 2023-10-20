# Notas iniciais

- Sintaxe para iniciar e terminar um arquivo PHP: <?php?>
- Todo arquivo PHP só pode rodar em um ambiente com protocolo HTTP/HTTPS. No caso, os arquivos dessa pasta estão sendo rodados dentro da pasta htdocs do XAMPP, com o Apache iniciado.
- O PHP não roda do lado do cliente, e sim do servidor. Ou seja, nenhum script escrito aparece para o cliente, como no F12. Quando o comando echo("Hello World!") é executado, o F12 mostra que foi adicionado texto ao `<body>`, mas não mostra os scripts PHP.

```php
<?php
    echo("Hello World!);
?>
```
