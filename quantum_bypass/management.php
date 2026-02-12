<?php
// Quantum Security Hint:
// For advanced access, set the following HTTP headers:
// X-QUANTUM-AUTH: Q_AUTH_2026_VALIDATED
// X-QUANTUM-NETWORK: QNET_2026_INTERNAL
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'employee') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Management Page | Quantum Corp</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background: #f8fafc; color: #222; }
        .navbar { background: linear-gradient(90deg, #e3f2fd 0%, #90caf9 100%); }
        .navbar-brand, .nav-link, .btn-outline-light { color: #1976d2 !important; }
        .management-header { background: linear-gradient(90deg, #90caf9 0%, #e3f2fd 100%); color: #1976d2; border-radius: 0.5rem; padding: 2rem 1rem 1rem 1rem; margin-bottom: 2rem; }
        .card.bg-secondary { background: #e3f2fd !important; color: #1976d2; }
        .card-icon { font-size: 2.5rem; color: #1976d2; }
        footer { color: #888; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-atom"></i> Quantum Corp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="#">Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Resources</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Company News</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Support</a></li>
                </ul>
                <form method="post" action="logout.php" class="d-flex mb-0">
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div class="management-header text-center mb-4">
            <h1 class="mb-1"><i class="fa-solid fa-users-gear"></i> Management Portal</h1>
            <p class="lead mb-0">Welcome to the Quantum Corp Management Page. Here you can view company stats, manage resources, and more.</p>
        </div>
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card bg-secondary h-100">
                    <div class="card-body text-center">
                        <div class="card-icon mb-2"><i class="fa-solid fa-chart-line"></i></div>
                        <h5 class="card-title">Company Stats</h5>
                        <p class="card-text">View real-time company performance metrics and analytics.</p>
                        <a href="#" class="btn btn-outline-info btn-sm disabled">View Stats</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary h-100">
                    <div class="card-body text-center">
                        <div class="card-icon mb-2"><i class="fa-solid fa-users"></i></div>
                        <h5 class="card-title">Team Management</h5>
                        <p class="card-text">Manage your team, assign tasks, and review progress.</p>
                        <a href="#" class="btn btn-outline-info btn-sm disabled">Manage Team</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-secondary h-100">
                    <div class="card-body text-center">
                        <div class="card-icon mb-2"><i class="fa-solid fa-file-invoice"></i></div>
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text">Access company reports, financials, and documentation.</p>
                        <a href="#" class="btn btn-outline-info btn-sm disabled">View Reports</a>
                    </div>
                </div>
            </div>
        </div>
        <footer class="mt-5 text-center text-muted">
            &copy; 2026 Quantum Corp. All rights reserved.
        </footer>

        <div class="alert alert-info mt-4" style="max-width: 600px; margin: 0 auto;">
            <strong>Quantum Security Hint:</strong><br>
            For advanced access, set the following HTTP headers:<br>
            <span style="font-family:monospace;">X-QUANTUM-AUTH: Q_AUTH_2026_VALIDATED</span><br>
            <span style="font-family:monospace;">X-QUANTUM-NETWORK: QNET_2026_INTERNAL</span>
        </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
