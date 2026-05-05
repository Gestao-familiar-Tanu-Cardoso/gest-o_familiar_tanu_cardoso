<?php
session_start();
// Conexão com o banco
$conn = new mysqli("localhost", "root", "", "gestao_familiar");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usuario'];
    $pass = $_POST['senha'];

    // Consulta simples (Nota: Para nível máximo real, use password_hash futuramente)
    $res = $conn->query("SELECT * FROM usuarios WHERE usuario = '$user' AND senha = '$pass'");
    
    if ($res && $res->num_rows > 0) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_nome'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Acesso negado. Verifique os seus dados.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Família Core</title>
    <!-- Fontes e Ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --dark: #0f172a;
            --text-gray: #64748b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            overflow: hidden;
        }

        /* Fundo Decorativo Animado */
        .circles {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            overflow: hidden; z-index: -1;
        }
        .circles li {
            position: absolute; display: block; list-style: none; width: 20px; height: 20px;
            background: rgba(255, 255, 255, 0.05); animation: animate 25s linear infinite; bottom: -150px;
        }
        @keyframes animate {
            0%{ transform: translateY(0) rotate(0deg); opacity: 1; border-radius: 0; }
            100%{ transform: translateY(-1000px) rotate(720deg); opacity: 0; border-radius: 50%; }
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 1);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            text-align: center;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            background: var(--primary);
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }

        h2 { color: var(--dark); margin-bottom: 10px; font-size: 24px; }
        p.subtitle { color: var(--text-gray); margin-bottom: 30px; font-size: 14px; }

        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            transition: 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            font-family: inherit;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
            background: #f8fafc;
        }

        .input-group input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .input-group input:focus + i { color: var(--primary); }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }

        .error-msg {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>
<body>

    <!-- Elementos Decorativos de Fundo -->
    <ul class="circles">
        <li style="left: 25%; width: 80px; height: 80px; animation-delay: 0s;"></li>
        <li style="left: 10%; width: 20px; height: 20px; animation-delay: 2s; animation-duration: 12s;"></li>
        <li style="left: 70%; width: 20px; height: 20px; animation-delay: 4s;"></li>
    </ul>

    <div class="login-container">
        <div class="login-card">
            <div class="brand-logo">
                <i class="fas fa-house-family"></i>
            </div>
            <h2>Bem-vindo de volta</h2>
            <p class="subtitle">Introduza as suas credenciais para aceder ao Família Core</p>

            <?php if(isset($erro)): ?>
                <div class="error-msg">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="usuario" placeholder="Nome de utilizador" required autofocus>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="senha" placeholder="Palavra-passe" required>
                </div>

                <button type="submit" class="btn-login">
                    ENTRAR NO SISTEMA
                </button>
            </form>
        </div>
        
        <p style="text-align: center; color: rgba(255,255,255,0.5); font-size: 12px; margin-top: 20px;">
            &copy; 2026 Família Core - Sistema de Gestão Privado
        </p>
    </div>

</body>
</html>