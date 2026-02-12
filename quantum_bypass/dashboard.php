<?php
// X-Quantum-Auth: Q_AUTH_2026_VALIDATED
// X-Quantum-Network: QNET_2026_INTERNAL
session_start();

// Another decoy page
header('Location: login.php');
exit();
?>