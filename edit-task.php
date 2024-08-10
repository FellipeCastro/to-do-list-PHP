<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    // Verificando se um ID de tarefa foi passado via GET
    if (isset($_GET["task_id"])) {
        include_once("config.php");

        $task_id = $_GET["task_id"];
        $user_id = $_SESSION["id"];

        // Preparando a consulta para buscar a tarefa
        $task_query = "SELECT * FROM tasks WHERE id = '$task_id' AND user_id = '$user_id'";
        $task_result = $connection -> query($task_query);

        // Verificando se a tarefa existe
        if ($task_result -> num_rows > 0) {
            $task = $task_result -> fetch_assoc();
        } else {
            echo "Tarefa não encontrada.";
            exit();
        }
    } else {
        echo "ID da tarefa não fornecido.";
        exit();
    }

    // Verificando se o formulário foi enviado para atualização
    if (isset($_POST["submit"])) {
        $task_title = $_POST["task"];

        // Atualizando a tarefa no banco de dados
        $update_query = "UPDATE tasks SET title = '$task_title' WHERE id = '$task_id' AND user_id = '$user_id'";
        $update_result = $connection -> query($update_query);

        if ($update_result) {
            header("Location: home.php");
            exit();
        } else {
            echo "Erro ao atualizar tarefa: " . mysqli_error($connection);
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>?task_id=<?= htmlspecialchars($task_id) ?>" method="post" autocomplete="off">
            <fieldset>
                <legend>Editar tarefa</legend>

                <div class="input-container">
                    <label for="task">Tarefa:</label>
                    <input type="text" name="task" id="task" value="<?= htmlspecialchars($task["title"]); ?>" required>
                </div>

                <input type="submit" name="submit" value="Atualizar tarefa" class="btn">
            </fieldset>
        </form>
    </div>
</body>
</html>
