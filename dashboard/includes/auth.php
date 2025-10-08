<?php
// Start session securely
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'use_strict_mode' => true,
        'use_only_cookies' => true
    ]);
}

// Function to safely destroy a session
function secure_logout() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['username'])) {
    secure_logout();
    header("Location: ../login.php");
    exit;
}

// Only allow admin users
if ($_SESSION['role'] !== 'admin') {
    secure_logout();
    header("Location: ../login.php");
    exit;
}

// Optional: regenerate session periodically to prevent fixation
if (!isset($_SESSION['last_regen'])) {
    $_SESSION['last_regen'] = time();
} elseif (time() - $_SESSION['last_regen'] > 300) { // every 5 minutes
    session_regenerate_id(true);
    $_SESSION['last_regen'] = time();
}

// Set username for dashboard usage
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>
