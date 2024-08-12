<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["name"])) {
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
        <h1>Olá, <?= htmlspecialchars($_SESSION["name"]); ?></h1>
        <abbr title="Sair">
            <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#ff0000"><path d="M186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h292.66v66.67H186.67v586.66h292.66V-120H186.67Zm470.66-176.67-47-48 102-102H360v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg></a>
        </abbr>
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