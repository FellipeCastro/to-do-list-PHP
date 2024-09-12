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

        $sql = "INSERT INTO tasks (user_id, title) VALUES ('$user_id', '$task');";
        $result = $connection -> query($sql);
        
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
        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" autocomplete="off">
            <h2 class="mb-3 text-center">Nova tarefa</h2>

            <div class="mb-3">
                <label for="task" class="form-label">Tarefa:</label>
                <input type="text" name="task" id="task" class="form-control" placeholder="Digite sua tarefa" required>
            </div>

            <input type="submit" name="submit" value="Nova tarefa" class="btn btn-primary mb-3 container-fluid">
        </form>
    </div>
</body>
</html>