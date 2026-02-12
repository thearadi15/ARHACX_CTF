<?php
function is_valid_hex($str) {
    return preg_match('/^[a-f0-9]{64}$/i', $str);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $errors = [];
    
    // Layer 1: quantum_token GET parameter
    if (!isset($_GET['quantum_token']) || $_GET['quantum_token'] !== 'SECURE2026_ADMIN') {
        $errors[] = "Layer 1: Invalid quantum_token";
    }
    
    // Layer 2: temporal_sig (64 hex chars)
    if (!isset($_GET['temporal_sig']) || !is_valid_hex($_GET['temporal_sig'])) {
        $errors[] = "Layer 2: Invalid temporal_sig";
    }
    
    // Layer 3: timestamp (2026 + 10 digits)
    if (!isset($_GET['timestamp']) || !preg_match('/^2026\d{10}$/', $_GET['timestamp'])) {
        $errors[] = "Layer 3: Invalid timestamp";
    }
    
    // Layer 4: User-Agent header
    if (stripos($_SERVER['HTTP_USER_AGENT'] ?? '', 'quantum_browser_2026') === false) {
        $errors[] = "Layer 4: Invalid User-Agent";
    }
    
    // Layer 5: Custom headers
    if (!isset($_SERVER['HTTP_X_QUANTUM_AUTH']) || $_SERVER['HTTP_X_QUANTUM_AUTH'] !== 'Q_AUTH_2026_VALIDATED') {
        $errors[] = "Layer 5a: Missing X-QUANTUM-AUTH";
    }
    
    if (!isset($_SERVER['HTTP_X_QUANTUM_NETWORK']) || $_SERVER['HTTP_X_QUANTUM_NETWORK'] !== 'QNET_2026_INTERNAL') {
        $errors[] = "Layer 5b: Missing X-QUANTUM-NETWORK";
    }
    
    // If any layer fails, show 403
    if (!empty($errors)) {
        http_response_code(403);
        include '../403.php';
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Always return 401 by default
    $status = 'quantum_failed';
    $message = 'Quantum credentials invalid';
    $http_code = 401;
    
    // Return JSON response
    header('Content-Type: application/json');
    http_response_code($http_code);
    $response = [
        'status' => $status,
        'message' => $message,
        'timestamp' => time()
    ];
    echo json_encode($response, JSON_PRETTY_PRINT);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum Admin Authentication</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantum-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="quantum-card p-4">
                    <div class="text-center mb-4">
                        <h2 class="text-primary">⚛️ Quantum Admin Login</h2>
                        <p class="text-muted">5-layer security bypassed successfully!</p>
                    </div>
                    
                    <!-- ...existing code... -->
                    
                    <form id="quantumLoginForm">
                        <div class="mb-3">
                            <label class="form-label">Username (any)</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter anything" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (any)</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter anything" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            Submit & Intercept Response
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.getElementById('quantumLoginForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        try {
            // POST to current URL
            const response = await fetch(window.location.pathname, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (response.status === 200 && result.status === 'quantum_success') {
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    window.location.href = 'quantum_control.php';
                }
            } else {
                // No hints or alerts
            }
            
        } catch (error) {
            alert('Error: ' + error.message);
            console.error('Fetch error:', error);
        }
    });
    </script>
</body>
</html>