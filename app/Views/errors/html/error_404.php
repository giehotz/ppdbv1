<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-grid {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            animation: gridMove 20s linear infinite;
        }
        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(60px, 60px); }
        }

        /* Floating Orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 8s ease-in-out infinite;
        }
        .orb-1 {
            width: 400px; height: 400px;
            background: #6366f1;
            top: -100px; right: -100px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 300px; height: 300px;
            background: #06b6d4;
            bottom: -80px; left: -80px;
            animation-delay: -3s;
        }
        .orb-3 {
            width: 200px; height: 200px;
            background: #10b981;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -5s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        /* Main Container */
        .container {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        /* Glitch 404 Number */
        .error-code {
            font-size: clamp(8rem, 20vw, 14rem);
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(135deg, #818cf8, #06b6d4, #34d399);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradientShift 4s ease-in-out infinite;
            position: relative;
            letter-spacing: -4px;
        }
        .error-code::after {
            content: '404';
            position: absolute;
            left: 4px; top: 4px;
            background: linear-gradient(135deg, #f43f5e, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0.3;
            z-index: -1;
        }
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Subtitle */
        .subtitle {
            font-size: 1.25rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-top: 0.5rem;
            letter-spacing: 0.5px;
        }

        /* Description */
        .description {
            color: #94a3b8;
            margin-top: 1rem;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* Error Detail (dev mode) */
        .error-detail {
            margin-top: 1.5rem;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-family: 'Courier New', monospace;
            font-size: 0.8rem;
            color: #f87171;
            text-align: left;
            word-break: break-all;
            backdrop-filter: blur(10px);
        }
        .error-detail .label {
            color: #64748b;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: block;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
        }

        /* Buttons */
        .actions {
            margin-top: 2.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.08);
            color: #cbd5e1;
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
        }
        .btn-secondary:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
            color: white;
        }

        /* SVG Icon */
        .btn svg {
            width: 18px; height: 18px;
            fill: currentColor;
        }

        /* Floating Particles */
        .particle {
            position: fixed;
            width: 4px; height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            animation: rise linear infinite;
        }
        @keyframes rise {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Floating Particles -->
    <script>
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + 'vw';
            p.style.animationDuration = (Math.random() * 6 + 4) + 's';
            p.style.animationDelay = (Math.random() * 6) + 's';
            p.style.width = p.style.height = (Math.random() * 3 + 2) + 'px';
            document.body.appendChild(p);
        }
    </script>

    <div class="container">
        <div class="error-code">404</div>
        <div class="subtitle">Halaman Tidak Ditemukan</div>
        <p class="description">
            Maaf, halaman yang Anda cari tidak ada, telah dipindahkan, atau mungkin URL-nya salah ketik. 
            Silakan kembali ke beranda atau gunakan navigasi untuk menemukan yang Anda butuhkan.
        </p>

        <?php if (ENVIRONMENT !== 'production') : ?>
            <div class="error-detail">
                <span class="label">🔍 Debug Info</span>
                <?= nl2br(esc((string) $message)) ?>
            </div>
        <?php endif; ?>

        <div class="actions">
            <a href="<?= site_url('/') ?>" class="btn btn-primary">
                <svg viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                Kembali ke Beranda
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
                <svg viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/></svg>
                Halaman Sebelumnya
            </button>
        </div>
    </div>
</body>
</html>
