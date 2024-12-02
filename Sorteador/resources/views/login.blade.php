<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
    <title>Login - Sorteador</title>

    <style>
        * {
            padding: 0;
            margin: 0;
        }

        /* Container com a imagem de fundo */
        .container {
            display: flex; /* Usando flexbox para facilitar o alinhamento */
            width: 100vw; /* Largura total da janela de visualização */
            height: 100vh; /* Altura total da janela de visualização */
            background-image: url('images/fundo3.webp'); /* Caminho correto para a imagem */
            background-color: #f0f0f0; /* Cor de fundo caso a imagem não carregue */
            background-size: cover; /* A imagem cobre toda a área */
            background-position: center; /* A imagem é centralizada */
            background-repeat: no-repeat; /* A imagem não se repete */
            background-attachment: fixed; /* A imagem ficará fixa enquanto a página rola */
            justify-content: center; /* Centraliza a div-login horizontalmente */
            align-items: center; /* Centraliza a div-login verticalmente */
        }

        /* Estilo do formulário de login */
        .div-login {
            height: 450px;
            width: 25%; /* Largura fixa */
            background-color: rgba(187, 191, 194, 0.65); /* Cor de fundo com opacidade */
            border: 3px solid #013101; /* Cor da borda */
            border-radius: 10px; /* Bordas arredondadas */
            padding: 30px; /* Espaçamento interno */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centraliza os itens dentro do formulário */
            text-align: center; /* Alinha o texto ao centro */
            font-size: 15pt;
        }

        /* Estilo dos inputs e botão */
        .form-control-lg {
            margin-bottom: 5px; /* Espaço entre os campos */
        }

        .image-logo{
            width: 20%; /* A imagem ocupará metade da largura */
            background-image: url('images/logo-irdeb.png'); /* Substitua pelo caminho da sua imagem */
            background-size: cover;
            background-position: center;
        }
        button {
            width: 100%; /* O botão ocupa toda a largura da div-login */
            padding: 10px; /* Padding para o botão */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="image-logo"></div>
    <div class="div-login">
        <form>
            <h1>👤Login</h1><br>
            <label for="usuario">Usuário:</label><br>
            <input class="form-control form-control-lg" type="text" id="usuario"><br>
            <label for="senha">Senha:</label><br>
            <input class="form-control form-control-lg" type="password" id="senha"><br>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</div>

</body>
</html>
