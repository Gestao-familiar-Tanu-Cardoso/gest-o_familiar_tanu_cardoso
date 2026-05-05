<?php
// 3. TRAVA DE SEGURANÇA (Sessão deve vir antes de qualquer HTML)
session_start();
if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

// 1. CONEXÃO COM O BANCO DE DADOS
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// 2. BUSCA DE MÉTRICAS PARA O DASHBOARD
$res_total = $conn->query("SELECT COUNT(*) as total FROM membros");
$total_membros = ($res_total) ? $res_total->fetch_assoc()['total'] : 0;

$ultimos_membros = $conn->query("SELECT * FROM membros ORDER BY id DESC LIMIT 5");
$distribuicao = $conn->query("SELECT parentesco, COUNT(*) as qtd FROM membros GROUP BY parentesco LIMIT 4");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Família Core | Dashboard Profissional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --danger: #ff4d4d;
            --dark: #1e1e2d;
            --sidebar: #151521;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; 
            background-color: #f3f4f7; 
            display: flex; 
            transition: 0.3s;
        }

        /* Lógica de Modo Escuro das Definições */
        body.dark-mode { background: #1a1a2e; color: #fff; }
        body.dark-mode .metric-card, body.dark-mode .content-card { background: #16213e; color: #fff; }
        body.dark-mode td, body.dark-mode h3, body.dark-mode h4 { color: #fff; }

        /* SIDEBAR */
        .sidebar { width: 260px; background: var(--sidebar); height: 100vh; position: fixed; color: #a2a3b7; }
        .sidebar-brand { padding: 30px; color: white; font-size: 22px; font-weight: 700; border-bottom: 1px solid #2b2b40; }
        .nav-menu { padding: 20px 0; }
        .nav-menu a { 
            padding: 15px 30px; color: #a2a3b7; text-decoration: none; display: flex; 
            align-items: center; transition: 0.3s; font-size: 14px;
        }
        .nav-menu a i { margin-right: 15px; font-size: 18px; }
        .nav-menu a:hover, .nav-menu a.active { background: #1b1b28; color: var(--success); border-right: 4px solid var(--success); }
        
        /* Botão Sair Especial */
        .nav-menu a.logout { color: #ff6b6b; margin-top: 50px; border: none; }
        .nav-menu a.logout:hover { background: rgba(255, 107, 107, 0.1); color: #ff4d4d; }

        /* CONTEÚDO */
        .main { margin-left: 260px; padding: 40px; width: 100%; }
        
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .metric-card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; align-items: center; }
        .metric-icon { width: 50px; height: 50px; border-radius: 12px; background: rgba(67, 97, 238, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px; margin-right: 20px; }
        
        .dashboard-row { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        .content-card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; color: #b5b5c3; font-size: 11px; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #f1f1f1; font-size: 14px; }
        
        .btn-action { background: var(--primary); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .badge { padding: 5px 12px; border-radius: 6px; font-size: 11px; background: #e1e9ff; color: #4361ee; font-weight: 700; }
    </style>
</head>
<body class="<?php echo isset($_SESSION['tema']) && $_SESSION['tema'] == 'dark' ? 'dark-mode' : ''; ?>">

    <div class="sidebar">
        <div class="sidebar-brand">Família Core</div>
        <div class="nav-menu">
            <a href="index.php" class="active"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a href="pages/listar.php"><i class="fas fa-user-friends"></i> Membros</a>
            <a href="pages/arvore_visual.php"><i class="fas fa-network-wired"></i> Árvore</a>
            <a href="pages/pdf.php"><i class="fas fa-print"></i> Relatórios</a>
            <a href="pages/configuracoes.php"><i class="fas fa-sliders-h"></i> Definições</a>
            
            <!-- 4. BOTÃO DE SAIR -->
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Sair do Sistema</a>
        </div>
    </div>

    <div class="main">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <h2>Resumo da Família</h2>
            <a href="pages/cadastro.php" class="btn-action"><i class="fas fa-plus"></i> NOVO MEMBRO</a>
        </div>

        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon"><i class="fas fa-users"></i></div>
                <div class="metric-data">
                    <h3 style="margin:0;"><?php echo $total_membros; ?></h3>
                    <p style="margin:0; font-size:12px; color:#888;">Membros Ativos</p>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon" style="color:var(--success); background:rgba(76,201,240,0.1);"><i class="fas fa-shield-alt"></i></div>
                <div class="metric-data">
                    <h3 style="margin:0;">Ativo</h3>
                    <p style="margin:0; font-size:12px; color:#888;">Segurança do Sistema</p>
                </div>
            </div>
        </div>

        <div class="dashboard-row">
            <div class="content-card">
                <h4>Atividades Recentes</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Membro</th>
                            <th>Parentesco</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($ultimos_membros): ?>
                            <?php while($row = $ultimos_membros->fetch_assoc()): ?>
                            <tr>
                                <td style="display: flex; align-items: center; gap: 10px;">
                                    <?php 
                                    $foto_caminho = "uploads/" . $row['foto'];
                                    if (!empty($row['foto']) && file_exists($foto_caminho)): ?>
                                        <img src="<?php echo $foto_caminho; ?>" style="width:32px; height:32px; border-radius:50%; object-fit:cover;">
                                    <?php else: ?>
                                        <div style="width:32px; height:32px; border-radius:50%; background:#eee; display:flex; align-items:center; justify-content:center; font-size:11px;">
                                            <?php echo strtoupper(substr($row['nome'], 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <strong><?php echo htmlspecialchars($row['nome']); ?></strong>
                                </td>
                                <td><span class="badge"><?php echo htmlspecialchars($row['parentesco']); ?></span></td>
                                <td><a href="pages/editar.php?id=<?php echo $row['id']; ?>" style="color:var(--primary);"><i class="fas fa-edit"></i></a></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="content-card">
                <h4>Estatísticas</h4>
                <?php if($distribuicao): ?>
                    <?php while($d = $distribuicao->fetch_assoc()): ?>
                    <div style="margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 5px;">
                            <span><?php echo htmlspecialchars($d['parentesco']); ?></span>
                            <strong><?php echo $d['qtd']; ?></strong>
                        </div>
                        <div style="background: #eee; height: 6px; border-radius: 10px; overflow: hidden;">
                            <?php $percent = ($total_membros > 0) ? ($d['qtd'] / $total_membros) * 100 : 0; ?>
                            <div style="background: var(--primary); width: <?php echo $percent; ?>%; height: 100%;"></div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>