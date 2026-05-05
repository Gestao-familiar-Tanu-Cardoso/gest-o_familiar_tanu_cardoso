<?php
session_start();

// 1. LIMPAR CACHE (Simulação)
if (isset($_GET['acao']) && $_GET['acao'] == 'limpar_cache') {
    // No PHP, isso limpa arquivos temporários se houver
    header("Location: configuracoes.php?msg=Cache limpo com sucesso!");
    exit;
}

// 2. RESETAR BANCO DE DADOS
if (isset($_GET['acao']) && $_GET['acao'] == 'reset_db') {
    $conn = new mysqli("localhost", "root", "", "gestao_familiar");
    $conn->query("TRUNCATE TABLE membros"); // Apaga todos os dados da tabela
    header("Location: configuracoes.php?msg=Sistema resetado!");
    exit;
}

// 3. ALTERAR TEMA (Modo Escuro)
if (isset($_POST['tema'])) {
    $_SESSION['tema'] = $_POST['tema']; // Salva na sessão do usuário
    echo "Sucesso";
    exit;
}
?>