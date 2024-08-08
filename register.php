<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List PHP</title>
    <link rel="stylesheet" href="css/formStyle.css">
</head>
<body>
    <div class="form-container">
        <form action="" method="post" autocomplete="off">
            <fieldset>
                <legend>Cadastre-se</legend>

                <div class="input-container">
                    <label for="username">Usuário:</label>
                    <input type="text" name="username" id="username" placeholder="Digite seu nome de usuário" required>
                </div>

                <div class="input-container">
                    <label for="email">E-mail:</label>
                    <input type="text" name="email" id="email" placeholder="Digite seu nome de usuário" required>
                </div>

                <div class="input-container">
                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
                </div>

                <button type="submit" class="btn">Cadastre-se</button>

                <p class="link">Já tem uma conta? <a href="login.php">Faça seu login aqui!</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>