<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Definições do Sistema</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Estilos baseados no que já criamos */
        :root { --primary: #2c3e50; --accent: #3498db; --danger: #e74c3c; --bg: #f8f9fa; }
        
        /* LÓGICA DE MODO ESCURO */
        body.dark-mode { background: #1a1a2e; color: #ffffff; }
        body.dark-mode .settings-card { background: #16213e; border: 1px solid #0f3460; }
        
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 30px; transition: 0.3s; }
        .settings-card { background: white; padding: 25px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .btn-danger { background: var(--danger); color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; }
        .btn-blue { background: var(--accent); color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; }
    </style>
</head>
<body class="<?php echo isset($_SESSION['tema']) && $_SESSION['tema'] == 'dark' ? 'dark-mode' : ''; ?>">

    <div class="header">
        <a href="../index.php" style="text-decoration:none; color:var(--accent);">← Voltar</a>
        <h1>Definições do Sistema</h1>
        <?php if(isset($_GET['msg'])) echo "<p style='color:green;'>".$_GET['msg']."</p>"; ?>
    </div>

    <!-- Personalização -->
    <div class="settings-card">
        <h3><i class="fas fa-paint-brush"></i> Personalização</h3>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <p>Modo Escuro</p>
            <button onclick="toggleTheme()" class="btn-blue">Alternar Tema</button>
        </div>
    </div>

    <!-- Manutenção -->
    <div class="settings-card">
        <h3><i class="fas fa-tools"></i> Manutenção do Sistema</h3>
        <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
            <span>Otimizar Banco de Dados</span>
            <a href="processar_configuracoes.php?acao=limpar_cache" class="btn-blue">LIMPAR AGORA</a>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span style="color:red;">Apagar todos os membros (Reset)</span>
            <button onclick="confirmarReset()" class="btn-danger">RESET TOTAL</button>
        </div>
    </div>

    <script>
        function toggleTheme() {
            document.body.classList.toggle('dark-mode');
            let tema = document.body.classList.contains('dark-mode') ? 'dark' : 'light';
            
            // Salva a preferência via AJAX para o PHP lembrar
            fetch('processar_configuracoes.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'tema=' + tema
            });
        }

        function confirmarReset() {
            if (confirm("ATENÇÃO: Isso apagará TODOS os nomes cadastrados. Deseja continuar?")) {
                window.location.href = "processar_configuracoes.php?acao=reset_db";
            }
        }
    </script>
</body>
</html>