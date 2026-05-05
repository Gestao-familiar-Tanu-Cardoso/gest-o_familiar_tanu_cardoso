<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

// 1. BUSCAR DADOS DO MEMBRO
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM membros WHERE id = $id");
    $membro = $result->fetch_assoc();
}

// 2. ATUALIZAR DADOS
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $parentesco = $_POST['parentesco'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE membros SET nome='$nome', parentesco='$parentesco', telefone='$telefone' WHERE id=$id";
    
    if ($conn->query($sql)) {
        header("Location: ../index.php"); // Volta para o início após salvar
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Membro</title>
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { color: #2c3e50; margin-top: 0; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-save { background: #3498db; color: white; border: none; padding: 12px; width: 100%; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #95a5a6; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Editar Membro</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $membro['id']; ?>">
            
            <label>Nome Completo</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($membro['nome']); ?>" required>
            
            <label>Parentesco</label>
            <input type="text" name="parentesco" value="<?php echo htmlspecialchars($membro['parentesco']); ?>">
            
            <label>Telefone</label>
            <input type="text" name="telefone" value="<?php echo htmlspecialchars($membro['telefone']); ?>">
            
            <button type="submit" class="btn-save">SALVAR ALTERAÇÕES</button>
            <a href="../index.php" class="btn-cancel">Cancelar e Voltar</a>
        </form>
    </div>
</body>
</html>