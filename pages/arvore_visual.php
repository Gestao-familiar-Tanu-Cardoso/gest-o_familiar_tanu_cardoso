<?php
$conn = new mysqli("localhost", "root", "", "gestao_familiar");
$sql = "SELECT * FROM membros";
$result = $conn->query($sql);

// Prepara os dados para o JavaScript
$membros = [];
while($row = $result->fetch_assoc()) {
    $membros[] = $row;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Árvore Genealógica Premium</title>
    <!-- Bibliotecas de Visualização de Árvore -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
        .tree-container { width: 100%; height: 600px; background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Estilo dos Cartões na Árvore */
        .node { 
            padding: 10px; 
            border-radius: 8px; 
            background: #fff; 
            border: 2px solid #3498db; 
            width: 180px; 
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .node-name { font-weight: bold; color: #2c3e50; font-size: 14px; margin-bottom: 5px; }
        .node-title { font-size: 12px; color: #7f8c8d; text-transform: uppercase; }
        .node-contact { font-size: 11px; color: #3498db; margin-top: 5px; }
        
        .header-arvore { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-voltar { text-decoration: none; color: #3498db; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header-arvore">
        <h2><i class="fas fa-sitemap"></i> Estrutura Familiar</h2>
        <a href="../index.php" class="btn-voltar"><i class="fas fa-arrow-left"></i> Voltar ao Painel</a>
    </div>

    <!-- Onde a árvore será desenhada -->
    <div id="tree-simple" class="tree-container"></div>

    <!-- Scripts Necessários -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/treant-js/1.0/Treant.js"></script>

    <script>
        // Configuração visual da árvore
        var chart_config = {
            chart: {
                container: "#tree-simple",
                levelSeparation: 45,
                siblingSeparation: 30,
                subTreeSeparation: 30,
                rootOrientation: "NORTH", // Árvore de cima para baixo
                connectors: {
                    type: "step",
                    style: {
                        "stroke-width": 2,
                        "stroke": "#bdc3c7"
                    }
                },
                node: { HTMLclass: "node" }
            },
            
            // Definição dos membros (Nós)
            nodeStructure: {
                text: { 
                    name: "Patriarca/Matriarca",
                    title: "Origem da Família"
                },
                children: [
                    <?php 
                    // Gera os filhos dinamicamente do banco de dados
                    foreach($membros as $m) {
                        echo "{
                            text: {
                                name: '" . addslashes($m['nome']) . "',
                                title: '" . addslashes($m['parentesco']) . "',
                                contact: '" . addslashes($m['telefone']) . "'
                            }
                        },";
                    }
                    ?>
                ]
            }
        };

        // Renderiza a árvore
        new Treant(chart_config);
    </script>
</body>
</html>