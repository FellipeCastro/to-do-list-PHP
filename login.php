<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List PHP</title>
    <link rel="stylesheet" href="css/formStyle.css">
</head>
<body>
    <?php 
        // Iniciando a sessão
        session_start();

        // Verificando se o fomulário foi enviado
        if (isset($_POST["submit"])) {
            include_once("config.php");

            $username = $_POST["username"];
            $password = $_POST["password"];

            $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";

            $result = $connection -> query($sql);

            // Se o número de linhas for menor que 1, ou seja, se não existir esse usuário
            if (mysqli_num_rows($result) < 1) {
                // Deletando dados da sessão
                unset($_SESSION["username"]);
                unset($_SESSION["password"]);
                header("Location: login.php");
            } else {
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                header("Location: home.php");
            }
        } else {
            // Se o formulário não for enviado o sistema não é acessado
            header("Location: login.php");
        }
    ?>

    <div class="form-container">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
            <fieldset>
                <legend>Login</legend>

                <div class="input-container">
                    <label for="username">Usuário:</label>
                    <input type="text" name="username" id="username" placeholder="Digite seu nome de usuário" required>
                </div>

                <div class="input-container">
                    <label for="password">Senha:</label>
                    <input type="password" name="password" id="password" placeholder="Digite sua senha" required>
                </div>

                <input type="submit" name="submit" value="Login" class="btn">

                <p class="link">Ainda não tem uma conta? <a href="register.php">Cadastre-se aqui!</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>