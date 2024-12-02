<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sorteador</title>
    <!-- Link do Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">


    <!-- Estilos personalizados (se necessário) -->
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f9;
            background-image: url('images/fundo5.jpg'); /* Caminho correto para a imagem */
            background-size: cover; /* A imagem cobre toda a área */
            background-position: center; /* A imagem é centralizada */
            background-repeat: no-repeat; /* A imagem não se repete */
            background-attachment: fixed; /* A imagem ficará fixa enquanto a página rola */
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: rgb(255, 255, 255);
            border-radius: 10px;
            border: 2px solid black;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="login-container">
    <!--<h3 class="text-center mb-4">Login</h>-->
    <!-- Logo acima do formulário -->
    <div class="text-center mb-4">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
    </div>
    <form>
        <div class="mb-3">
            <label for="username" class="form-label">Nome de usuário</label>
            <input type="text" class="form-control" id="username" placeholder="Digite seu nome de usuário" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
        </div>
        <div class="d-flex justify-content-between">
            <div>
                <input type="checkbox" id="rememberMe"> <label for="rememberMe">Lembrar de mim</label>
            </div>
            <div>
                <a href="#">Esqueceu a senha?</a>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-3">Entrar</button>
    </form>
</div>

<!-- Scripts do Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
