<?php
session_start();

// If user is not logged in, redirect to index
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// If already accepted, go to dashboard
if (isset($_SESSION['accepted_terms']) && $_SESSION['accepted_terms'] === true) {
    header("Location: dashboard.php");
    exit();
}

// Handle Accept
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_terms'])) {
    $_SESSION['accepted_terms'] = true;
    unset($_SESSION['declined_terms']);
    header("Location: dashboard.php");
    exit();
}

// Handle Decline → Logout and redirect to index
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decline_terms'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
