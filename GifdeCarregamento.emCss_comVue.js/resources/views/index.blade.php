<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>gif de carregamento</title>
    @vite('resources/js/app.js')
</head>
<body>

    <!--
        A DIV 
        [<div id="app-root"> <routerviewpage /></div>]
        deve ficar na pagina principal do projeto para receber todas as outras páginas e componentes.
        a importação acontece por meio do components.js
    -->

    <div id="app-root">
        <routerviewpage />
    </div>

</body>
</html>