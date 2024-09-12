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
        
        <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="add-task.php">Nova tarefa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Sair</a>
                </li>
        </ul>
    </header>

    <div class="container">
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
