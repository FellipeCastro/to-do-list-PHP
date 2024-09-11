<?php 
    // Iniciando a sessão
    session_start();

    // Verificando se o usuário está logado
    if (!isset($_SESSION["id"]) || !isset($_SESSION["name"])) {
        header("Location: login.php");
        exit();
    }

    // Verificando se o task_id foi passado pela URL
    if (isset($_GET["task_id"])) {
        include_once("config.php");

        $task_id = $_GET["task_id"];
        $user_id = $_SESSION["id"];
        $is_done = $_GET["is_done"];

        // Definindo o novo status da tarefa
        $new_status = $is_done == "true" ? "pending" : "completed";

        // Atualizando o status da tarefa no banco de dados
        $sql = "UPDATE tasks SET status = '$new_status' WHERE id = '$task_id'";
        $result = $connection -> query($sql);

        if ($result) {
            header("Location: home.php");
            exit();
        } else {
            echo "Erro ao atualizar status da tarefa: " . mysqli_error($connection);
        }
    } else {
        echo "ID da tarefa não fornecido.";
    }
?>
