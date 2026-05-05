<?php
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM membros WHERE id = $id";
    $conn->query($sql);
}

header("Location: ../index.php"); // Redireciona de volta para a lista
exit;
?>