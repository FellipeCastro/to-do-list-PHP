<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["name"])) {
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
            exit();
        }
    } else {
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
        <h1>Olá, <?= htmlspecialchars($_SESSION["name"]); ?></h1>
        <abbr title="Sair">
            <a href="logout.php"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#ff0000"><path d="M186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h292.66v66.67H186.67v586.66h292.66V-120H186.67Zm470.66-176.67-47-48 102-102H360v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg></a>
        </abbr>
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
