<?php
session_start();

// Handle real login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Real employee credentials
    $valid_user = 'EMP2026001';
    $valid_pass = 'quantum2026';

    if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION['user'] = 'employee';
        header('Location: management.php');
        exit();
    } elseif ($username && $password) {
        $_SESSION['error'] = "Invalid employee credentials. Please contact HR.";
    } else {
        $_SESSION['error'] = "Please enter both username and password.";
    }
    header('Location: login.php');
    exit();
}

// Check for hints in robots.txt or other files
$hint = '';
if (isset($_GET['debug'])) {
    $hint = "<!-- DEBUG: Real challenge starts in /admin/ directory -->";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal - Quantum Corp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            padding-top: 100px;
        }
        .company-logo {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .hint-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ff6b6b;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8em;
            cursor: help;
        }
        .security-notice {
            font-size: 0.8em;
            color: #7f8c8d;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php if ($hint) echo $hint; ?>
    
    <div class="hint-badge" data-bs-toggle="tooltip" title="This is a distraction! Look elsewhere.">
        ⚠️ Employee Portal
    </div>
    
    <div class="container">
        <div class="login-container">
            <div class="company-logo">
                <h1>🔒 Quantum Corp</h1>
                <p class="text-muted">Employee Portal v2.0</p>
            </div>
            
            <div class="card shadow">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Employee Login</h4>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); endif; ?>
                    
                    <form method="POST" action="login.php">
                        <div class="mb-3">
                            <label class="form-label">Employee ID</label>
                            <input type="text" name="username" class="form-control" placeholder="e.g., EMP2026001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <a href="forgot-password.php" class="text-decoration-none">Forgot Password?</a>
                        <span class="mx-2">•</span>
                        <a href="register.php" class="text-decoration-none">New Employee?</a>
                    </div>
                </div>
            </div>
            
            <div class="security-notice">
                <p>⚠️ This portal is for Quantum Corp employees only.</p>
                <p>Unauthorized access attempts are logged and monitored.</p>
                <p class="mt-2"><small>v2.0.2026 • Security Level: <span class="text-danger">HIGH</span></small></p>
            </div>
            
            <!-- Hidden hint for observant players -->
            <div style="opacity: 0.1; font-size: 0.7em; text-align: center; margin-top: 20px;">
                <!-- Real admin panel uses quantum parameters -->
                <!-- Check admin/ directory for quantum authentication -->
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Tooltip initialization
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
    
    // Console message for observant players
    console.log("%c🔍 Employee Portal Loaded", "color: #3498db; font-weight: bold;");
    console.log("%c💡 Hint: This might not be what you're looking for...", "color: #e74c3c;");
    </script>
</body>
</html>