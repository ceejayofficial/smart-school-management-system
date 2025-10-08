<?php
session_start();
require_once "db.php";

// Only handle POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please fill in both fields.";
        header("Location: login.php");
        exit;
    }

    // Prepare statement to get user by email
    $stmt = $conn->prepare("SELECT user_id, username, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $username, $dbEmail, $dbPasswordHash, $role);
        $stmt->fetch();

        if (password_verify($password, $dbPasswordHash)) {
            // Successful login
            session_regenerate_id(true);
            $_SESSION['user_id']   = $userId;
            $_SESSION['username']  = $username;
            $_SESSION['email']     = $dbEmail;
            $_SESSION['role']      = $role;

            // Redirect based on role
            switch ($role) {
                case 'admin':
                    $redirect = "dashboard/admin_dashboard.php";
                    break;
                case 'teacher':
                    $redirect = "dashboard/teacher_dashboard.php";
                    break;
                case 'parent':
                    $redirect = "dashboard/parent_dashboard.php";
                    break;
                default:
                    $redirect = "login.php"; // fallback
            }

            $_SESSION['login_success']  = "Login successful! Redirecting...";
            $_SESSION['login_redirect'] = $redirect;

            header("Location: login.php");
            exit;

        } else {
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: login.php");
            exit;
        }

    } else {
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: login.php");
        exit;
    }

    $stmt->close();

} else {
    // Redirect if page accessed directly
    header("Location: login.php");
    exit;
}
?>
