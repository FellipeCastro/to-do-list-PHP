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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS -->
    <style>
        body {
            background-color: #eee;
            width: 100%;
            height: 100vh;
            position: relative;
        }

        header {
            width: 100%;
            position: absolute;
            top: 0;
        }

        header h2 {
            color: #fff;
        }

        .container {
            width: 500px;
            max-width: 500px;
            background-color: #fff;
            padding: 1em;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <header class="navbar navbar-expand-sm bg-dark navbar-dark d-flex align-items-center justify-content-between p-3 mb-5">
        <h2 class="">Olá, <?= $_SESSION["name"]; ?></h2>

        <abbr title="Sair">
            <a href="logout.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="40px" fill="#fff"><path d="M186.67-120q-27 0-46.84-19.83Q120-159.67 120-186.67v-586.66q0-27 19.83-46.84Q159.67-840 186.67-840h292.66v66.67H186.67v586.66h292.66V-120H186.67Zm470.66-176.67-47-48 102-102H360v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg>
            </a>
        </abbr>
    </header>

    <div class="container">
        <abbr title="Volar">
            <a href="home.php">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 0 448 512"><path fill="#212529" d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
            </a>
        </abbr>
        
        <form action="<?= $_SERVER["PHP_SELF"] ?>?task_id=<?= $task_id ?>" method="post" autocomplete="off">
            <h2 class="mb-3 text-center">Editar tarefa</h2>

            <div class="mb-3">
                <label for="task" class="form-label">Tarefa:</label>
                <input type="text" name="task" id="task" class="form-control" value="<?= $task["title"]; ?>" required>
            </div>

            <input type="submit" name="submit" value="Atualizar tarefa" class="btn btn-primary mb-3 container-fluid">
        </form>
    </div>
</body>
</html>
