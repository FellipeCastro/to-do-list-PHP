<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
        // Se não estiver logado, redireciona para a página de login
        header("Location: login.php");
        exit();
    }

    // Verificando se o fomulário foi enviado
    if (isset($_POST["submit"])) {
        include_once("config.php");

        $task = $_POST["task"];
        $task_id = $_GET["task_id"];
        $user_id = $_SESSION["id"];

        $result = mysqli_query($connection, "INSERT INTO tasks (user_id, title) VALUES ('$user_id', '$task');");
        
        if ($result) {
            header("Location: home.php");
            exit();
        } else {
            echo "Erro ao adicionar tarefa: " . mysqli_error($connection);
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
    <header>
        <h1>Olá, <?= htmlspecialchars($_SESSION["username"]); ?></h1>
        <a href="logout.php">Sair</a>
    </header>

    <div class="form-container">
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
            <fieldset>
                <legend>Nova tarefa</legend>

                <div class="input-container">
                    <label for="task">Tarefa:</label>
                    <input type="text" name="task" id="task" placeholder="Digite sua tarefa" required>
                </div>

                <input type="submit" name="submit" value="Nova tarefa" class="btn">
            </fieldset>
        </form>
    </div>
</body>
</html>