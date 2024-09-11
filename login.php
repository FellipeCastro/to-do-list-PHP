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
            if (password_verify($password, $user['password'])) {
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
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <style>
        body {
            background-color: #eee;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 500px;
            max-width: 500px;
            background-color: #fff;
            padding: 1em;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
            <h2 class="mb-3 text-center">Login</h2>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
            </div>

            <input type="submit" name="submit" class="btn btn-primary mb-3 container-fluid" value="Login">

            <p class="text-center">Ainda não tem uma conta? <a href="register.php">Cadastre-se aqui!</a></p>
        </form>
    </div>
</body>
</html>
