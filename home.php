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
    <link rel="stylesheet" href="css/styleHome.css">
</head>
<body>
    <header>
        <h1>Olá, <?= htmlspecialchars($_SESSION["name"]); ?></h1>
        <a href="logout.php" class="logout"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#ff0000"><path d="M480.67-120v-66.67h292.66v-586.66H480.67V-840h292.66q27 0 46.84 19.83Q840-800.33 840-773.33v586.66q0 27-19.83 46.84Q800.33-120 773.33-120H480.67Zm-63.34-176.67-47-48 102-102H120v-66.66h351l-102-102 47-48 184 184-182.67 182.66Z"/></svg></a>
    </header>

    <main>
        <h2 class="title">Suas tarefas</h2>
        <a href="add-task.php">Adicionar tarefa</a>

        <div class="tasks">
            <?php 
                // Verificando se a consulta retornou resultados
                if ($tasks_result -> num_rows > 0) {
                    // Iterando sobre os resultados e exibindo as tarefas
                    while($task = $tasks_result -> fetch_assoc()) {
                        // Adiciona a classe 'done' se a tarefa estiver concluída
                        $task_class = $task["status"] == "completed" ? "done" : "";

                        echo "<div class='task $task_class'>";
                        echo "<h3>" . htmlspecialchars($task["title"]) . "</h3>";
                        echo "<div class='btn-container'>
                                <a href='delete-task.php?task_id=" . $task['id'] . "' class='delete-btn'><svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z'/></svg></a>

                                <a href='edit-task.php?task_id=" . $task['id'] . "' class='edit-btn'><svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z'/></svg></a>

                                <a href='done-task.php?task_id=" . $task['id'] . "&is_done=" . ($task["status"] == "completed" ? "true" : "false") . "' class='done-btn'><svg xmlns='ttp://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'><path d='M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z'/></svg></a>

                            </div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Nenhuma tarefa encontrada.</p>";
                }
            ?>
        </div>

    </main>
</body>
</html>
