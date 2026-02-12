<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Quantum Forbidden</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Arial', sans-serif;
        }
        .error-container {
            text-align: center;
            padding: 40px;
            background: rgba(0,0,0,0.7);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            max-width: 800px;
        }
        h1 {
            font-size: 6em;
            margin: 0;
            color: #ff6b6b;
            text-shadow: 0 0 20px rgba(255,107,107,0.5);
        }
        .hint-section {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: left;
        }
        .layer-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 20px;
        }
        .layer-item {
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <h2>Quantum Security Breach Detected</h2>
        <p>Access forbidden.</p>
        
        <div style="margin-top: 30px;">
            <?php
            // Show errors if available
            if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['bypass_errors'])) {
                echo '<div style="background: rgba(255,0,0,0.2); padding: 10px; border-radius: 5px; margin-bottom: 15px;">';
                echo '<strong>Failed Layers:</strong><br>';
                foreach ($_SESSION['bypass_errors'] as $error) {
                    echo "• " . htmlspecialchars($error) . "<br>";
                }
                unset($_SESSION['bypass_errors']);
                echo '</div>';
            }
            ?>
            
            <a href="../login.php" style="color: #4fc3f7; text-decoration: none; font-size: 1.2em;">
                ← Return to Login
            </a>
        </div>
    </div>
</body>
</html>