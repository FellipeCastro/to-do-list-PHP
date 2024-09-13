<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["name"])) {
        // Se não estiver logado, redireciona para a página de login
        header("Location: login.php");
        exit();
    }

    // Conectando ao banco de dados
    include_once("config.php");

    // Preparando a consulta SQL para buscar as tarefas do usuário logado
    $user_id = $_SESSION["id"];
    $tasks_sql = "SELECT * FROM tasks WHERE user_id = '$user_id'";
    $tasks_result = $connection -> query($tasks_sql);
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
            min-height: 100vh;
        }

        header h2 {
            color: #fff;
        }

        .container {
            width: 800px;
            max-width: 800px;
            background-color: #fff;
            padding: 1em;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .done h5 {
            text-decoration: line-through;
            opacity: 0.5;
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

    <main class="container">
        <div class="container-fluid d-flex align-items-center justify-content-between mb-4">
            <h2>Suas tarefas</h2>
            <a href="add-task.php">Adicionar tarefa</a>
        </div>

        <div class="tasks">
            <?php 
                // Verificando se a consulta retornou resultados
                if ($tasks_result -> num_rows > 0) {
                    // Iterando sobre os resultados e exibindo as tarefas
                    while($task = $tasks_result -> fetch_assoc()) {
                        // Adiciona a classe 'done' se a tarefa estiver concluída
                        $task_class = $task["status"] == "completed" ? "done" : "";

                        echo "<div class='shadow-sm border rounded container-fluid d-flex align-items-center justify-content-between p-2 mb-3 $task_class'>";
                        echo "<h5>" . $task["title"] . "</h6>";
                        echo "<div class='btn-container'>
                                <a href='delete-task.php?task_id=" . $task["id"] . "' class='btn btn-danger p-2'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z'/></svg>
                                </a>

                                <a href='edit-task.php?task_id=" . $task["id"] . "' class='btn btn-primary p-2'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z'/>
                                </svg></a>

                                <a href='done-task.php?task_id=" . $task["id"] . "&is_done=" . ($task["status"] == "completed" ? "true" : "false") . "' class='btn btn-success p-2'>
                                    <svg xmlns='ttp://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z'/></svg>
                                </a>

                            </div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='text-center'>Nenhuma tarefa encontrada.</p>";
                }
            ?>
        </div>

    </main>
</body>
</html>
