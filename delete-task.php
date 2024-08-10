<?php 
// Iniciando a sessão
session_start();

// Verificando se o usuário está logado
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Verificando se o task_id foi passado pela URL
if (isset($_GET["task_id"])) {
    include_once("config.php");

    $task_id = $_GET["task_id"];
    $user_id = $_SESSION["id"];

    // Deletando a tarefa
    $result = mysqli_query($connection, "DELETE FROM tasks WHERE id = '$task_id' AND user_id = '$user_id'");

    if ($result) {
        header("Location: home.php");
        exit();
    } else {
        echo "Erro ao deletar tarefa: " . mysqli_error($connection);
    }
} else {
    echo "ID da tarefa não fornecido.";
}
?>
