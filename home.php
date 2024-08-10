<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List PHP</title>
    <link rel="stylesheet" href="css/homeStyle.css">
</head>
<body>
    <?php 
        // Iniciando a sessão
        session_start();

        // Verificando se o usuário está logado
        if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
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

    <header>
        <h1>Olá, <?= htmlspecialchars($_SESSION["username"]); ?></h1>
        <a href="logout.php">Sair</a>
    </header>

    <main>
        <a href="#">Adicionar tarefa</a>

        <div class="tasks">
            <?php 
                // Verificando se a consulta retornou resultados
                if ($tasks_result->num_rows > 0) {
                    // Iterando sobre os resultados e exibindo as tarefas
                    while($task = $tasks_result->fetch_assoc()) {
                        echo "<div class='task'>";
                        echo "<h2>" . htmlspecialchars($task['title']) . "</h2>";
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
