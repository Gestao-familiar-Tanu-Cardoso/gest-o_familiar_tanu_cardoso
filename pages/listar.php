<?php
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

// Consulta todos os membros
$sql = "SELECT * FROM membros ORDER BY nome ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Membros da Família - Vista Premium</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        :root { --primary: #2c3e50; --accent: #3498db; --bg: #f0f2f5; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); margin: 0; padding: 30px; }
        
        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        /* Grid de Membros */
        .members-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
        }

        /* CARD COM FOTO (PASSO 5) */
        .member-card { 
            background: white; border-radius: 15px; padding: 25px; text-align: center;
            transition: 0.3s; position: relative; overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .member-card:hover { transform: translateY(-5px); }
        
        .avatar { 
            width: 100px; height: 100px; 
            border-radius: 50%; 
            margin: 0 auto 15px; 
            display: flex; align-items: center; justify-content: center;
            font-size: 35px; color: var(--primary); font-weight: bold;
            border: 4px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-size: cover;
            background-position: center;
            background-color: #eee;
        }

        .member-info h3 { margin: 10px 0 5px; color: var(--primary); }
        .member-info span { 
            display: inline-block; padding: 4px 12px; background: #e1f5fe; 
            color: #0288d1; border-radius: 20px; font-size: 12px; font-weight: 600;
        }
        
        .card-actions { 
            margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f1f1;
            display: flex; justify-content: space-around; 
        }
        .action-link { text-decoration: none; font-size: 18px; }
        .edit-link { color: #f1c40f; }
        .delete-link { color: #e74c3c; }
        .btn-voltar { text-decoration: none; color: var(--primary); font-weight: bold; }
    </style>
</head>
<body>

    <div class="header-actions">
        <div>
            <a href="../index.php" class="btn-voltar"><i class="fas fa-arrow-left"></i> Painel Principal</a>
            <h1 style="margin: 10px 0;">Membros da Família</h1>
        </div>
    </div>

    <div class="members-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // LÓGICA DE EXIBIÇÃO DA IMAGEM (PASSO 4)
                $foto_perfil = !empty($row['foto']) ? "../uploads/" . $row['foto'] : null;
                $estilo_avatar = $foto_perfil && file_exists($foto_perfil) 
                                 ? "style='background-image: url(\"$foto_perfil\");'" 
                                 : "";
                ?>
                <div class="member-card">
                    <div class="avatar" <?php echo $estilo_avatar; ?>>
                        <?php if (empty($estilo_avatar)) echo strtoupper(substr($row['nome'], 0, 1)); ?>
                    </div>
                    
                    <div class="member-info">
                        <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                        <span><?php echo htmlspecialchars($row['parentesco']); ?></span>
                    </div>
                    
                    <p style="font-size:13px; color:#7f8c8d; margin-top:10px;">
                        <i class="fas fa-phone"></i> <?php echo htmlspecialchars($row['telefone']); ?>
                    </p>

                    <div class="card-actions">
                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="action-link edit-link"><i class="fas fa-edit"></i></a>
                        <a href="excluir.php?id=<?php echo $row['id']; ?>" class="action-link delete-link" onclick="return confirm('Apagar membro?')"><i class="fas fa-trash"></i></a>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</body>
</html>