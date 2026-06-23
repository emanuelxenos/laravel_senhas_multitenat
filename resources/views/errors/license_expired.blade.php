<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Bloqueado - Licença Expirada</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-arena: linear-gradient(185deg, #180a02 0%, #050200 100%);
            --gold: #d97706;
            --gold-light: #fbbf24;
            --gold-glow: rgba(217, 119, 6, 0.15);
            --glass-bg: rgba(24, 10, 2, 0.65);
            --glass-border: rgba(217, 119, 6, 0.18);
            --text-gold: #fde047;
            --text-light: #fffbeb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(185deg, rgba(24, 10, 2, 0.95) 0%, rgba(5, 2, 0, 0.98) 100%), url('/vaquejada_bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        .dust-overlay {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(217, 119, 6, 0.02) 1px, transparent 0);
            background-size: 32px 32px;
            z-index: 1;
            pointer-events: none;
        }

        .lock-container {
            z-index: 10;
            position: relative;
            width: 100%;
            max-width: 500px;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .lock-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 3rem 2rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
            border-top: 4px solid var(--gold);
        }

        .lock-icon-wrapper {
            width: 90px;
            height: 90px;
            background: rgba(217, 119, 6, 0.08);
            border: 2px solid var(--glass-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .lock-icon-wrapper i {
            font-size: 2.5rem;
            color: var(--gold-light);
            text-shadow: 0 0 15px rgba(217, 119, 6, 0.5);
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        p {
            color: #fed7aa;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .support-info {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .support-info h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .support-info p {
            font-size: 0.9rem;
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .btn-support {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            color: #180a02;
            background: linear-gradient(to bottom, #f59e0b, #d97706);
            border-bottom: 4px solid #b45309;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            gap: 0.6rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .btn-support:hover {
            background: linear-gradient(to bottom, #fbbf24, #f59e0b);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px var(--gold-glow);
        }

        .footer-logo {
            margin-top: 2rem;
            font-family: 'Outfit', sans-serif;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.15);
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <div class="dust-overlay"></div>

    <div class="lock-container">
        <div class="lock-card">
            <div class="lock-icon-wrapper">
                <i class="fas fa-lock"></i>
            </div>
            
            <h1>Licença Expirada</h1>
            @if(isset($parque_nome))
                <p style="color: #fed7aa; font-weight: 600; margin-bottom: 0.5rem; font-size: 1.2rem;">Parque: {{ $parque_nome }}</p>
            @endif
            @if(isset($expires_at))
                <p style="color: #fca5a5; font-size: 0.95rem; margin-bottom: 1.5rem;">Licença expirada em: {{ $expires_at }}</p>
            @endif
            <p>Este período de uso do sistema foi concluído. Para reativar a sua licença de uso ou estender o prazo, entre em contato com o desenvolvedor.</p>
            
            <div class="support-info">
                <h3>Suporte ao Cliente</h3>
                <p>Desenvolvido por: <strong>@emanuelxenos</strong></p>
            </div>
            
            <a href="https://instagram.com/emanuelxenos" target="_blank" class="btn-support">
                <i class="fab fa-instagram" style="font-size: 1.25rem;"></i>
                Entrar em Contato
            </a>
        </div>
        
        <div class="footer-logo">
            Vaquejada OS &bull; Sistema de Gestão
        </div>
    </div>

</body>
</html>
