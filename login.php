<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o fomulário foi enviado
    if (isset($_POST["submit"])) {
        include_once("config.php");

        $email = $_POST["email"];
        $password = $_POST["password"];

        // Consulta para verificar se o usuário existe
        $sql = "SELECT * FROM users WHERE email = '$email'";

        $result = $connection -> query($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = $result -> fetch_assoc();
            
            // Verificando se a senha inserida corresponde à senha do banco de dados
            if ($password == $user["password"]) {
                // Adicionando o ID e o nome de usuário à sessão
                $_SESSION["id"] = $user["id"];
                $_SESSION["name"] = $user["name"];

                header("Location: home.php");
                exit();
            } else {
                echo "<span class='error'>Senha incorreta!</span>";
            }
        } else {
            echo "<span class='error'>Usuário não encontrado!</span>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List PHP</title>
    <link rel="stylesheet" href="css/styleForm.css">
</head>
<body>
    <div class="form-container">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
            <fieldset>
                <legend>Login</legend>

                <div class="input-container">
                    <label for="email">E-mail:</label>
                    <input type="text" name="email" id="email" placeholder="Digite seu e-mail de usuário" required>
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
