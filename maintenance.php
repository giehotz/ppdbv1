<?php
/**
 * Maintenance Page
 * 
 * PHP, CSS, and JS Self-Contained Maintenance Page.
 * Automatically sends 503 Service Unavailable status header for SEO.
 */

// Send standard 503 headers to prevent search engine indexing
header('HTTP/1.1 503 Service Unavailable');
header('Status: 503 Service Unavailable');
header('Retry-After: 3600'); // Suggest retry in 1 hour (3600 seconds)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemeliharaan Sistem | PPDB</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: rgba(17, 24, 39, 0.7);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: #94a3b8;
            --accent-primary: #3b82f6; /* Modern Blue */
            --accent-secondary: #8b5cf6; /* Violet */
            --accent-glow: rgba(59, 130, 246, 0.5);
            --success-color: #10b981;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            padding: 20px;
        }

        /* Ambient Glowing Background Elements */
        .ambient-glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            z-index: 1;
            pointer-events: none;
        }

        .glow-1 {
            width: 400px;
            height: 400px;
            background: var(--accent-primary);
            top: -100px;
            left: -100px;
            animation: floatGlow 15s infinite ease-in-out alternate;
        }

        .glow-2 {
            width: 500px;
            height: 500px;
            background: var(--accent-secondary);
            bottom: -150px;
            right: -100px;
            animation: floatGlow 20s infinite ease-in-out alternate-reverse;
        }

        /* Card Layout */
        .maintenance-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 580px;
            text-align: center;
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            z-index: 10;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card-border-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
        }

        /* Animated Icon Container */
        .icon-container {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-bottom: 28px;
        }

        .pulse-ring {
            position: absolute;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            animation: pulse 2.5s infinite ease-in-out;
            z-index: -1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--success-color);
            box-shadow: 0 0 10px var(--success-color);
            animation: blink 1.5s infinite;
        }

        /* Typography */
        h1 {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.25;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        p.subtitle {
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Countdown Container */
        .countdown-wrapper {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px 10px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 32px;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .countdown-val {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            font-variant-numeric: tabular-nums;
            background: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .countdown-label {
            font-size: 11px;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.05em;
            margin-top: 4px;
        }

        /* Progress Bar */
        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 100px;
            overflow: hidden;
            margin-bottom: 36px;
        }

        .progress-bar {
            height: 100%;
            width: 75%; /* Simulative progress value */
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            border-radius: 100px;
            position: relative;
            animation: animateProgress 4s ease-in-out infinite alternate;
        }

        /* Footer/Actions */
        .footer-action {
            border-top: 1px solid var(--border-color);
            padding-top: 24px;
        }

        .footer-text {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 16px;
        }

        .btn-support {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-primary);
            padding: 10px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }

        .btn-support:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .btn-support svg {
            fill: currentColor;
            width: 16px;
            height: 16px;
        }

        /* Keyframes Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.4;
            }
            50% {
                transform: scale(1.25);
                opacity: 0.8;
            }
            100% {
                transform: scale(0.9);
                opacity: 0.4;
            }
        }

        @keyframes floatGlow {
            0% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, -50px) scale(1.1);
            }
            100% {
                transform: translate(-20px, 30px) scale(0.9);
            }
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        @keyframes animateProgress {
            0% {
                width: 60%;
            }
            100% {
                width: 85%;
            }
        }

        /* Responsive Settings */
        @media (max-width: 640px) {
            .maintenance-card {
                padding: 36px 24px;
            }
            h1 {
                font-size: 26px;
            }
            .countdown-val {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="maintenance-card">
        <div class="card-border-glow"></div>
        
        <div class="icon-container">
            <div class="pulse-ring"></div>
            <!-- Dynamic Cog Icon using SVG -->
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="url(#accentGrad)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: rotate 10s linear infinite;">
                <defs>
                    <linearGradient id="accentGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#3b82f6" />
                        <stop offset="100%" stop-color="#8b5cf6" />
                    </linearGradient>
                </defs>
                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <style>
                @keyframes rotate {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
            </style>
        </div>

        <div>
            <div class="status-badge">
                <span class="status-dot"></span>
                <span>Scheduled Maintenance</span>
            </div>
        </div>

        <h1>Pemeliharaan Sistem</h1>
        <p class="subtitle">Kami sedang melakukan beberapa pembaruan sistem untuk meningkatkan pengalaman pendaftaran PPDB Anda. Kami akan segera kembali dalam beberapa saat.</p>

        <!-- Countdown timer -->
        <div class="countdown-wrapper">
            <div class="countdown-item">
                <span class="countdown-val" id="days">00</span>
                <span class="countdown-label">Hari</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-val" id="hours">00</span>
                <span class="countdown-label">Jam</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-val" id="minutes">00</span>
                <span class="countdown-label">Menit</span>
            </div>
            <div class="countdown-item">
                <span class="countdown-val" id="seconds">00</span>
                <span class="countdown-label">Detik</span>
            </div>
        </div>

        <!-- Pulse progress bar -->
        <div class="progress-container">
            <div class="progress-bar"></div>
        </div>

        <!-- Support Info -->
        <div class="footer-action">
            <p class="footer-text">Butuh bantuan segera terkait pendaftaran?</p>
            <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" class="btn-support">
                <!-- WhatsApp Icon -->
                <svg viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.458 5.704 1.459h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi Panitia
            </a>
        </div>
    </div>

    <!-- Script for Countdown -->
    <script>
        // Set maintenance countdown target
        // Format: 'Month Day, Year HH:MM:SS' or dynamically set from current time
        // Let's set it to end in 3 hours from the visitor's first loading for demo purposes.
        // You can change this to a fixed date e.g., '2026-06-25T12:00:00'
        let targetDate = localStorage.getItem('maintenance_target');
        
        if (!targetDate) {
            const threeHoursFromNow = new Date();
            threeHoursFromNow.setHours(threeHoursFromNow.getHours() + 3);
            targetDate = threeHoursFromNow.toISOString();
            localStorage.setItem('maintenance_target', targetDate);
        }

        const countdownTarget = new Date(targetDate).getTime();

        const updateCountdown = () => {
            const now = new Date().getTime();
            const difference = countdownTarget - now;

            if (difference <= 0) {
                document.getElementById('days').innerText = '00';
                document.getElementById('hours').innerText = '00';
                document.getElementById('minutes').innerText = '00';
                document.getElementById('seconds').innerText = '00';
                
                // Optional: Reload the page when countdown completes to check if site is back up
                // window.location.reload();
                return;
            }

            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            // Format numbers to have leading zero
            document.getElementById('days').innerText = String(days).padStart(2, '0');
            document.getElementById('hours').innerText = String(hours).padStart(2, '0');
            document.getElementById('minutes').innerText = String(minutes).padStart(2, '0');
            document.getElementById('seconds').innerText = String(seconds).padStart(2, '0');
        };

        // Run countdown initially and set interval
        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>
</body>
</html>
