<?php
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $parentesco = $_POST['parentesco'];
    $telefone = $_POST['telefone'];
    
    // Lógica do Upload
    $foto_nome = "default.png";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nome = time() . "." . $extensao; // Nome único baseado no tempo
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_nome);
    }
    
    $sql = "INSERT INTO membros (nome, parentesco, telefone, foto) VALUES ('$nome', '$parentesco', '$telefone', '$foto_nome')";
    if ($conn->query($sql)) {
        header("Location: ../index.php");
        exit;
    }
}
?>
<!-- No HTML, adicione o campo de arquivo -->
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="nome" placeholder="Nome Completo" required>
    <input type="text" name="parentesco" placeholder="Parentesco">
    <input type="text" name="telefone" placeholder="Telefone">
    <label>Foto de Perfil:</label>
    <input type="file" name="foto" accept="image/*">
    <button type="submit" class="btn-save">Salvar Membro</button>
</form>