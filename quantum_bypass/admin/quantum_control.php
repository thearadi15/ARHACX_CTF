<?php
$FLAG = "RCS_CTF{QUANTUM_5_LAYER_BYPASS_2026_COMPLETE}";
// Prevent direct access: require a special header or GET param set by the bypass or manipulation
function is_bypass_or_manipulated() {
    // Allow if special header (from bypass) or a GET param (from manipulated redirect)
    if (
        (isset($_SERVER['HTTP_X_QUANTUM_AUTH']) && $_SERVER['HTTP_X_QUANTUM_AUTH'] === 'Q_AUTH_2026_VALIDATED') &&
        (isset($_SERVER['HTTP_X_QUANTUM_NETWORK']) && $_SERVER['HTTP_X_QUANTUM_NETWORK'] === 'QNET_2026_INTERNAL')
    ) {
        return true;
    }
    // Allow if redirected from manipulation (set by JS after JSON manipulation)
    if (isset($_GET['quantum_success']) && $_GET['quantum_success'] === '1') {
        return true;
    }
    return false;
}
if (!is_bypass_or_manipulated()) {
    header('Location: quantum_auth.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum Control Panel - Flag</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(120deg, #232526 0%, #414345 100%);
            min-height: 100vh;
            color: #fff;
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            overflow-x: hidden;
        }
        .flag-container {
            background: linear-gradient(135deg, #ff6b6b 0%, #f7b42c 100%);
            border-radius: 20px;
            padding: 48px 32px 32px 32px;
            text-align: center;
            margin: 40px 0 32px 0;
            animation: glow 2s infinite alternate;
            border: 4px solid #fff;
            box-shadow: 0 8px 32px 0 rgba(255,107,107,0.25);
            position: relative;
        }
        @keyframes glow {
            from { box-shadow: 0 0 24px 8px #ffb34788; }
            to { box-shadow: 0 0 48px 16px #ff6b6bcc; }
        }
        .flag-badge {
            font-size: 2.5rem;
            background: linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
            color: #fff;
            border-radius: 50%;
            padding: 18px 28px;
            margin-bottom: 18px;
            box-shadow: 0 2px 12px 0 #f7971e55;
            display: inline-block;
            border: 2px solid #fff;
        }
        .flag-text {
            font-family: 'Fira Mono', 'Consolas', monospace;
            font-size: 2.2rem;
            background: #232526;
            color: #ffe082;
            border-radius: 10px;
            padding: 18px 0;
            margin: 18px 0 0 0;
            letter-spacing: 2px;
            box-shadow: 0 2px 8px 0 #23252655;
            user-select: all;
        }
        .celebrate {
            font-size: 2.5rem;
            color: #f7b42c;
            margin-bottom: 10px;
            animation: pop 1.2s infinite alternate;
        }
        @keyframes pop {
            from { transform: scale(1); }
            to { transform: scale(1.08) rotate(-2deg); }
        }
        .card.bg-dark {
            background: linear-gradient(120deg, #232526 0%, #414345 100%);
            border-radius: 16px;
            border: 2px solid #fff2;
            box-shadow: 0 2px 12px 0 #0003;
        }
        .audit-list li {
            font-size: 1.1rem;
            margin-bottom: 6px;
        }
        .audit-list li .fa-check-circle {
            color: #4cd137;
        }
        .audit-list li .fa-user-secret {
            color: #00b894;
        }
        .audit-list li .fa-code-branch {
            color: #fdcb6e;
        }
        .audit-list li .fa-network-wired {
            color: #0984e3;
        }
        .audit-list li .fa-cogs {
            color: #e17055;
        }
        .audit-list li .fa-bolt {
            color: #fdcb6e;
        }
        .audit-list li .fa-key {
            color: #e17055;
        }
        .audit-list li .fa-flag-checkered {
            color: #f7b42c;
        }
        .audit-list li .fa-clock {
            color: #00b894;
        }
        .btn-success {
            font-size: 1.2rem;
            padding: 12px 32px;
            border-radius: 8px;
            font-weight: 600;
            box-shadow: 0 2px 8px 0 #4cd13755;
        }
        .btn-outline-light {
            font-size: 1.1rem;
            padding: 10px 28px;
            border-radius: 8px;
            font-weight: 500;
        }
        .footer {
            margin-top: 48px;
            text-align: center;
            color: #fff8;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center mb-5">
                    <div class="celebrate">
                        <i class="fa-solid fa-crown"></i> <span>Access Granted</span> <i class="fa-solid fa-crown"></i>
                    </div>
                    <h1 class="display-4 fw-bold">Quantum Control Panel</h1>
                    <p class="lead">Welcome to the <span class="fw-bold text-warning">Admin Vault</span>!</p>
                </div>
                <div class="flag-container shadow-lg">
                    <div class="flag-badge mb-3"><i class="fa-solid fa-flag-checkered"></i></div>
                    <div class="flag-text" id="flagText">
                        <span id="leetFlag"></span>
                    </div>
                    <p class="mt-3 mb-0">This is your access token.</p>
                </div>
                <div class="card bg-dark text-white mt-4 shadow">
                    <div class="card-header d-flex align-items-center">
                        <i class="fa-solid fa-shield-halved me-2"></i>
                        <h4 class="mb-0">Security Audit Log</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled audit-list mb-0">
                            <li><i class="fa-solid fa-check-circle"></i> Layer 1 (Quantum Token): <span class="text-success">BYPASSED</span></li>
                            <li><i class="fa-solid fa-user-secret"></i> Layer 2 (Temporal Sig): <span class="text-success">BYPASSED</span></li>
                            <li><i class="fa-solid fa-clock"></i> Layer 3 (Timestamp): <span class="text-success">BYPASSED</span></li>
                            <li><i class="fa-solid fa-network-wired"></i> Layer 4 (User-Agent): <span class="text-success">BYPASSED</span></li>
                            <li><i class="fa-solid fa-cogs"></i> Layer 5 (Custom Headers): <span class="text-success">BYPASSED</span></li>
                            <li><i class="fa-solid fa-bolt"></i> JSON Manipulation: <span class="text-warning">COMPLETE</span></li>
                            <li><i class="fa-solid fa-key"></i> Authentication: <span class="text-info">SUCCESS</span></li>
                            <li><i class="fa-solid fa-code-branch"></i> <span class="text-secondary">IP:</span> <?php echo $_SERVER['REMOTE_ADDR']; ?></li>
                            <li><i class="fa-solid fa-clock"></i> <span class="text-secondary">Time:</span> <?php echo date('Y-m-d H:i:s'); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button onclick="copyFlag()" class="btn btn-success btn-lg me-2">
                        <i class="fa-solid fa-copy"></i> Copy Flag
                    </button>
                    <button onclick="logoutAndRestart()" class="btn btn-outline-light">
                        <i class="fa-solid fa-rotate"></i> Restart Challenge
                    </button>
                    <script>
                    function logoutAndRestart() {
                        // Clear any local/session storage (if used)
                        try { localStorage.clear(); } catch(e){}
                        try { sessionStorage.clear(); } catch(e){}
                        window.location.href = 'quantum_auth.php?logout=1';
                    }
                    </script>
                </div>
                <div class="footer">
                    <span>&copy; 2026 Quantum Security</span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <script>
    function toLeet(str) {
        // Only convert inside the curly braces, keep RCS_CTF{} as is
        const match = str.match(/^(RCS_CTF\{)(.*)(\})$/);
        if (match) {
            const prefix = match[1];
            const content = match[2];
            const suffix = match[3];
            const leetContent = content
                .replace(/A/gi, '4')
                .replace(/B/gi, '8')
                .replace(/C/gi, '(')
                .replace(/E/gi, '3')
                .replace(/G/gi, '6')
                .replace(/I/gi, '1')
                .replace(/L/gi, '1')
                .replace(/O/gi, '0')
                .replace(/S/gi, '5')
                .replace(/T/gi, '7')
                .replace(/Z/gi, '2');
            return prefix + leetContent + suffix;
        } else {
            // fallback: leet the whole string
            return str
                .replace(/A/gi, '4')
                .replace(/B/gi, '8')
                .replace(/C/gi, '(')
                .replace(/E/gi, '3')
                .replace(/G/gi, '6')
                .replace(/I/gi, '1')
                .replace(/L/gi, '1')
                .replace(/O/gi, '0')
                .replace(/S/gi, '5')
                .replace(/T/gi, '7')
                .replace(/Z/gi, '2');
        }
    }
    function copyFlag() {
        const flag = "<?php echo $FLAG; ?>";
        navigator.clipboard.writeText(flag).then(() => {
            const btn = document.querySelector('.btn-success');
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
            setTimeout(() => {
                btn.innerHTML = '<i class=\"fa-solid fa-copy\"></i> Copy Flag';
            }, 1800);
        });
    }
    // Render leet flag on page load
    document.addEventListener('DOMContentLoaded', function() {
        const flag = "<?php echo $FLAG; ?>";
        document.getElementById('leetFlag').textContent = toLeet(flag);
    });
    // Confetti celebration effect
    (function confetti() {
        const colors = ["#f7b42c", "#ff6b6b", "#4cd137", "#00b894", "#0984e3", "#ffe082"];
        for (let i = 0; i < 60; i++) {
            let conf = document.createElement('div');
            conf.style.position = 'fixed';
            conf.style.top = Math.random() * 10 + '%';
            conf.style.left = Math.random() * 100 + '%';
            conf.style.width = '12px';
            conf.style.height = '12px';
            conf.style.background = colors[Math.floor(Math.random()*colors.length)];
            conf.style.opacity = 0.7;
            conf.style.borderRadius = '50%';
            conf.style.zIndex = 9999;
            conf.style.transition = 'top 2.5s linear, opacity 2.5s linear';
            document.body.appendChild(conf);
            setTimeout(() => {
                conf.style.top = '90%';
                conf.style.opacity = 0;
            }, 100);
            setTimeout(() => {
                conf.remove();
            }, 2700);
        }
    })();
    // Console celebration
    console.log('%c🎉 CONGRATULATIONS! 🎉', 'color: #f7b42c; font-size: 24px; font-weight: bold;');
    console.log('%cFlag: <?php echo $FLAG; ?>', 'color: #ff6b6b; font-size: 18px;');
    </script>
</body>
</html>