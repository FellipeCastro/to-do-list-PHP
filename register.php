<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List PHP</title>
    <link rel="stylesheet" href="css/stykeForm.css">
</head>
<body>
    <?php 
        // Verificando se o fomulário foi enviado
        if (isset($_POST["submit"])) {
            include_once("config.php");

            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            $result = mysqli_query($connection, "INSERT INTO users(username, password, email) VALUES ('$username', '$password', '$email')");
            
            if ($result) {
                header("Location: login.php");
                exit();
            } else {
                echo "Erro ao cadastrar o usuário: " . mysqli_error($connection);
            }
        }
    ?>

    <div class="form-container">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
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

                <input type="submit" name="submit" value="Cadstrar-se" class="btn">

                <p class="link">Já tem uma conta? <a href="login.php">Faça seu login aqui!</a></p>
            </fieldset>
        </form>
    </div>
</body>
</html>