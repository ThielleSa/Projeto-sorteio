<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Gerenciador de usuários</title>
</head>
<body>
    <h1>Usuários</h1>

    <div>
        <fieldset>
            <form>
                @csrf
                <label>Usuário:</label>
                <input type="text" class="form-control-sm" id="username" name="username" placeholder="Nome do usuário..." required>
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control-sm" id="password" name="password" placeholder="Senha do usuário..." required>
                <label>Permissão</label>
                <select class="form-control-sm" id="role" name="role">
                    <option>--Selecione--</option>
                    <option>admin</option>
                    <option>user</option>
                </select>
            </form>
        </fieldset>
    </div>

    <table>
        <thead>
            <tr>
                <td>Nome de usuário</td>
                <td>Senha</td>
                <td>Permissão</td>
                <td>Excluir</td>
            </tr>
        </thead>

        <tbody>

        </tbody>
    </table>
</body>
</html>
