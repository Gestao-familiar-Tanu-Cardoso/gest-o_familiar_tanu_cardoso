<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

// Busca dados para estatísticas
$total_membros = $conn->query("SELECT COUNT(*) as total FROM membros")->fetch_assoc()['total'];
$parentescos = $conn->query("SELECT parentesco, COUNT(*) as qtd FROM membros GROUP BY parentesco");

// Busca a lista completa para o relatório
$lista = $conn->query("SELECT * FROM membros ORDER BY nome ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios Avançados - Família Core</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary: #2c3e50; --accent: #3498db; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f7f6; margin: 0; padding: 40px; }
        
        .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn-print { background: var(--primary); color: white; padding: 12px 25px; border-radius: 8px; text-decoration: none; border: none; cursor: pointer; font-weight: bold; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid var(--accent); }
        .stat-card h2 { font-size: 32px; margin: 10px 0; color: var(--primary); }
        
        .report-table { width: 100%; background: white; border-collapse: collapse; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .report-table th { background: var(--primary); color: white; padding: 15px; text-align: left; }
        .report-table td { padding: 15px; border-bottom: 1px solid #eee; color: #444; }

        @media print {
            .btn-print, .btn-voltar { display: none; }
            body { background: white; padding: 0; }
            .stat-card { border: 1px solid #ddd; box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="report-header">
        <div>
            <a href="../index.php" class="btn-voltar" style="text-decoration: none; color: var(--accent);">← Voltar</a>
            <h1>Relatório Geral da Família</h1>
        </div>
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> IMPRIMIR RELATÓRIO
        </button>
    </div>

    <!-- Painel de Estatísticas Rapidamente Visíveis -->
    <div class="stats-grid">
        <div class="stat-card">
            <i class="fas fa-users" style="color: var(--accent);"></i>
            <p>Total de Membros</p>
            <h2><?php echo $total_membros; ?></h2>
        </div>
        <?php while($p = $parentescos->fetch_assoc()): ?>
        <div class="stat-card">
            <i class="fas fa-sitemap"></i>
            <p><?php echo htmlspecialchars($p['parentesco']); ?></p>
            <h2><?php echo $p['qtd']; ?></h2>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Tabela de Dados -->
    <table class="report-table">
        <thead>
            <tr>
                <th>Nome Completo</th>
                <th>Grau de Parentesco</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $lista->fetch_assoc()): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($row['nome']); ?></strong></td>
                <td><?php echo htmlspecialchars($row['parentesco']); ?></td>
                <td><?php echo htmlspecialchars($row['telefone']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: center; color: #999; font-size: 12px;">
        Relatório gerado em: <?php echo date('d/m/Y H:i'); ?>
    </div>

</body>
</html>