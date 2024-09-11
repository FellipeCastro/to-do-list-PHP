<?php 
    // Verificando se o fomulário foi enviado
    if (isset($_POST["submit"])) {
        include_once("config.php");

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Verificando se as senhas coincidem
        if ($password !== $confirm_password) {
            echo "<span class='error'>As senhas não coincidem!</span>";
        } else {
            // Verificando se o email já está cadastrado
            $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
            $check_email_result = $connection -> query($check_email_sql);
    
            if (mysqli_num_rows($check_email_result) > 0) {
                echo "<span class='error'>E-mail já cadastrado!</span>";
            } else {
                // Hash da senha usando o algoritmo padrão (atualmente Bcrypt)
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Inserindo o usuário no banco de dados
                $sql = "INSERT INTO users(name, password, email) VALUES ('$name', '$hashed_password', '$email')";
                $result = $connection -> query($sql);
            
                if ($result) {
                    header("Location: login.php");
                    exit();
                } else {
                    $error_message = "Erro ao cadastrar o usuário: " . mysqli_error($connection);
                }
            }
        }

    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
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
            <h2 class="mb-3 text-center">Cadastre-se</h2>

            <div class="mb-3">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Digite seu nome de usuário" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="Digite seu nome de usuário" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
            </div>

            <div class="mb-4">
                <label for="confirm_password" class="form-label">Confirme sua senha:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme sua senha" required>
            </div>

            <input type="submit" name="submit" class="btn btn-primary mb-3 container-fluid" value="Cadstrar-se">

            <p class="text-center">Já tem uma conta? <a href="login.php">Faça seu login aqui!</a></p>
        </form>
    </div>
</body>
</html>