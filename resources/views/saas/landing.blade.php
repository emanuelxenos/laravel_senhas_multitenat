<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sis Vaquejada - O Sistema Mais Moderno do Mundo para Gestão de Eventos e Parques</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-dark: #0a0401;
            --card-bg: rgba(24, 10, 2, 0.55);
            --gold: #d97706;
            --gold-light: #fbbf24;
            --gold-glow: rgba(217, 119, 6, 0.3);
            --text-light: #fef3c7;
            --text-dark: #78350f;
            --border-glow: rgba(217, 119, 6, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-dark);
            background-image: 
                linear-gradient(180deg, rgba(10, 4, 1, 0.9) 0%, rgba(10, 4, 1, 0.95) 100%),
                url('/vaquejada_bg.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fffbeb;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* HEADER / NAVIGATION */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
            background: rgba(10, 4, 1, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(217, 119, 6, 0.1);
        }

        .logo {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: var(--gold-light);
            text-shadow: 0 0 10px var(--gold-glow);
        }

        .logo span {
            background: linear-gradient(135deg, #fff 40%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav a {
            color: #fef3c7;
            text-decoration: none;
            font-weight: 600;
            margin-left: 2rem;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--gold-light);
        }

        .btn-login {
            background: transparent;
            border: 2px solid var(--border-glow);
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            color: #fff;
            font-weight: 700;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: #0a0401;
            box-shadow: 0 0 15px var(--gold-glow);
        }

        /* HERO SECTION */
        .hero {
            min-height: 100vh;
            padding: 8rem 10% 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 20%;
            width: 600px;
            height: 400px;
            background: radial-gradient(circle, rgba(217, 119, 6, 0.12) 0%, rgba(0,0,0,0) 70%);
            filter: blur(80px);
            z-index: -1;
        }

        .badge-premium {
            background: rgba(217, 119, 6, 0.1);
            border: 1px solid var(--gold);
            color: var(--gold-light);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2rem;
            text-shadow: 0 0 10px rgba(217, 119, 6, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 4.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: -1px;
            max-width: 1000px;
            background: linear-gradient(135deg, #fff 30%, #fde047 70%, var(--gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 1.35rem;
            color: #fbd5a9;
            max-width: 800px;
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1.5rem;
        }

        .btn-cta-primary {
            background: linear-gradient(180deg, #fbbf24 0%, #d97706 100%);
            color: #0f0500;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 4px solid #92400e;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.35);
        }

        .btn-cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(217, 119, 6, 0.5);
            background: linear-gradient(180deg, #fde047 0%, #f59e0b 100%);
        }

        .btn-cta-secondary {
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid var(--border-glow);
            color: #fff;
            text-decoration: none;
            padding: 1.2rem 2.5rem;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-cta-secondary:hover {
            background: rgba(217, 119, 6, 0.08);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* SECTION LAYOUT */
        section {
            padding: 8rem 10%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 5rem;
        }

        .section-title h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fff, var(--gold-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-title p {
            color: #fed7aa;
            font-size: 1.15rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* FEATURES GRID */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
        }

        .feature-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 3rem 2rem;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(217, 119, 6, 0.4);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 30px rgba(217, 119, 6, 0.05);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon-wrapper {
            width: 70px;
            height: 70px;
            background: rgba(217, 119, 6, 0.08);
            border: 1px solid rgba(217, 119, 6, 0.25);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--gold-light);
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .feature-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #fff;
        }

        .feature-card p {
            color: #cbd5e1;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* PERSUASIVE SHOWCASE SECTION */
        .showcase {
            background: rgba(10, 4, 1, 0.6);
            border-top: 1px solid rgba(217, 119, 6, 0.05);
            border-bottom: 1px solid rgba(217, 119, 6, 0.05);
            display: flex;
            align-items: center;
            gap: 5rem;
        }

        .showcase-content {
            flex: 1;
        }

        .showcase-content h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .showcase-content p {
            color: #cbd5e1;
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .showcase-list {
            list-style: none;
        }

        .showcase-list li {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
        }

        .showcase-list li i {
            color: var(--gold-light);
            font-size: 1.25rem;
            margin-top: 3px;
        }

        .showcase-image {
            flex: 1;
            position: relative;
        }

        .showcase-image img {
            width: 100%;
            border-radius: 16px;
            border: 1px solid var(--border-glow);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
        }

        .showcase-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 60%, var(--bg-dark));
            pointer-events: none;
            border-radius: 16px;
        }

        /* PRICING / CONTACT SECTION */
        .pricing {
            text-align: center;
            position: relative;
        }

        .pricing-card {
            background: linear-gradient(145deg, rgba(30, 15, 5, 0.7) 0%, rgba(10, 4, 1, 0.9) 100%);
            border: 2px solid var(--gold);
            border-radius: 24px;
            padding: 4rem 3rem;
            max-width: 600px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
            box-shadow: 0 30px 80px rgba(217, 119, 6, 0.15);
            position: relative;
        }

        .pricing-card::before {
            content: "O MAIS CONTRATADO";
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(90deg, #f59e0b, #d97706);
            color: #000;
            font-size: 0.75rem;
            font-weight: 900;
            padding: 0.4rem 1.5rem;
            border-radius: 50px;
            letter-spacing: 2px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .price {
            font-family: 'Outfit', sans-serif;
            font-size: 3.5rem;
            font-weight: 900;
            color: #fff;
            margin: 1.5rem 0;
        }

        .price span {
            font-size: 1.2rem;
            color: #fed7aa;
            font-weight: 500;
        }

        .price-features {
            list-style: none;
            text-align: left;
            max-width: 400px;
            margin: 2rem auto;
        }

        .price-features li {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
            font-size: 1.1rem;
        }

        .price-features li i {
            color: #10b981;
        }

        /* FOOTER */
        footer {
            padding: 5rem 10% 3rem;
            border-top: 1px solid rgba(217, 119, 6, 0.05);
            background: #060200;
            text-align: center;
        }

        .footer-logo {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.5rem;
        }

        .footer-logo i {
            color: var(--gold-light);
        }

        .footer-links {
            margin: 2rem 0;
        }

        .footer-links a {
            color: #a1a1aa;
            text-decoration: none;
            margin: 0 1.5rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--gold-light);
        }

        .copyright {
            color: #52525b;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255,255,255,0.03);
            padding-top: 2rem;
            margin-top: 2rem;
        }

        /* RESPONSIVIDADE */
        @media (max-width: 992px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .showcase {
                flex-direction: column;
                gap: 3rem;
            }

            .hero h1 {
                font-size: 3rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                width: 100%;
                max-width: 350px;
            }

            header {
                padding: 1.2rem 5%;
            }
            
            nav {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <a href="#" class="logo">
            <i class="fas fa-horse-head"></i>
            <span>Sis Vaquejada</span>
        </a>
        <nav>
            <a href="#funcionalidades">Diferenciais</a>
            <a href="#parque">O Sistema</a>
            <a href="#precos">Preços</a>
            <a href="{{ route('login') }}" class="btn-login">Entrar no Painel</a>
        </nav>
    </header>

    <!-- HERO -->
    <div class="hero">
        <div class="badge-premium">
            <i class="fas fa-crown me-2"></i> Lançamento Exclusivo
        </div>
        <h1>Esqueça as Filas. <br>Gerencie Todo o Seu Parque de Vaquejada.</h1>
        <p>O Sis Vaquejada é o único sistema do mercado que automatiza desde a venda de senhas online via PIX até a locução e o julgamento na pista de corrida. Tenha controle absoluto na palma da sua mão.</p>
        <div class="cta-buttons">
            <a href="#precos" class="btn-cta-primary">Começar Agora</a>
            <a href="#funcionalidades" class="btn-cta-secondary">Ver Diferenciais</a>
        </div>
    </div>

    <!-- FEATURES -->
    <section id="funcionalidades">
        <div class="section-title">
            <h2>Por que escolher o Sis Vaquejada?</h2>
            <p>Criamos a solução mais completa do mundo para automatizar o seu evento, testada e aprovada na pista.</p>
        </div>
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Vendas de Senhas Online</h3>
                <p>Os vaqueiros compram suas senhas diretamente pelo celular via PIX, escolhem a pedra na hora e o sistema confirma o pagamento em segundos sem nenhuma fila.</p>
            </div>
            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3>Split de Pagamento Inteligente</h3>
                <p>O sistema divide o valor das inscrições na hora: os custos do gateway e taxas administrativas são separados automaticamente, e o restante cai líquido e direto na conta bancária configurada pelo parque.</p>
            </div>
            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-microphone"></i>
                </div>
                <h3>Painel de Locução Rápida</h3>
                <p>Um painel exclusivo e otimizado para o locutor chamar as senhas no microfone com agilidade, controlando o andamento das corridas sem interrupções.</p>
            </div>
            <!-- Feature 4 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-gavel"></i>
                </div>
                <h3>Painel Digital do Juiz</h3>
                <p>O juiz define o resultado ("Boi Batido" ou "Zero") direto de um tablet na pista de julgamento. O status é atualizado na hora para todo o público.</p>
            </div>
            <!-- Feature 5 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-desktop"></i>
                </div>
                <h3>Gerenciamento Local & Offline</h3>
                <p>Quer usar apenas na secretaria do parque sem vendas online? Nosso instalador roda offline no Windows, permitindo gerenciar todo o evento e inscrições físicas sem depender de internet.</p>
            </div>
            <!-- Feature 6 -->
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <i class="fas fa-print"></i>
                </div>
                <h3>Impressão de Senhas e Recibos</h3>
                <p>Gere e imprima as senhas físicas dos competidores na secretaria. Tenha o controle total do evento na pista utilizando apenas as senhas impressas em sua impressora térmica.</p>
            </div>
        </div>
    </section>

    <!-- SHOWCASE 1 -->
    <section class="showcase" id="parque">
        <div class="showcase-content">
            <h2>O Controle da Vaquejada de forma Simples e Eficiente</h2>
            <p>O Sis Vaquejada organiza todo o fluxo de trabalho do seu parque em uma interface espetacularmente limpa e moderna. Veja o que está incluído:</p>
            <ul class="showcase-list">
                <li>
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Controle de Categorias Customizado:</strong>
                        <p class="text-sm text-gray-300">Defina o preço das senhas, o limite de compras por vaqueiro e a quantidade de bois por categoria de forma independente.</p>
                    </div>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Regra de Boi TV:</strong>
                        <p class="text-sm text-gray-300">Defina datas limites para compra online de bois de TV extras e automatize as vendas.</p>
                    </div>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Controle de Acessos:</strong>
                        <p class="text-sm text-gray-300">Contas dedicadas para Administrador, Secretária, Locutor e Juiz com permissões de segurança estritas.</p>
                    </div>
                </li>
                <li>
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <strong>Integração com WhatsApp:</strong>
                        <p class="text-sm text-gray-300">Envie o comprovante de inscrição, link do PIX de pagamento e a confirmação das senhas diretamente no WhatsApp do competidor.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="showcase-image">
            <img src="{{ asset('vaquejada_bg.png') }}" alt="Demonstração do Painel Sis Vaquejada">
        </div>
    </section>

    <!-- PRICING -->
    <section class="pricing" id="precos">
        <div class="section-title">
            <h2>Pronto para Alavancar Seu Parque?</h2>
            <p>Entre em contato com nossa equipe comercial para obter uma proposta personalizada para o seu evento.</p>
        </div>
        <div class="pricing-card">
            <h3>Fale Conosco</h3>
            <p class="text-muted">Consulte condições sob medida para o seu parque</p>
            <ul class="price-features">
                <li><i class="fas fa-check"></i> Inscrições e Senhas Online</li>
                <li><i class="fas fa-check"></i> Painel do Juiz & Locutor</li>
                <li><i class="fas fa-check"></i> Modo Portátil (Offline)</li>
                <li><i class="fas fa-check"></i> Fechamento de Caixa & Relatórios</li>
                <li><i class="fas fa-check"></i> Suporte 24 horas</li>
            </ul>
            <a href="https://instagram.com/emanuelxenos" target="_blank" class="btn-cta-primary w-100 mt-4 d-block" style="text-align: center;">Falar com Comercial</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-logo">
            <i class="fas fa-horse-head"></i> Sis Vaquejada
        </div>
        <p class="text-muted">A tecnologia de ponta que a tradição do vaqueiro merece.</p>
        <div class="footer-links">
            <a href="#funcionalidades">Diferenciais</a>
            <a href="#parque">O Sistema</a>
            <a href="#precos">Preços</a>
            <a href="{{ route('login') }}">Login Administrativo</a>
        </div>
        <div class="copyright">
            &copy; {{ date('Y') }} Sis Vaquejada &bull; Desenvolvido por @emanuelxenos. Todos os direitos reservados.
        </div>
    </footer>

</body>
</html>
