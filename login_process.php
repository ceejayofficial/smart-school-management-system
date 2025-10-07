<?php
session_start();
require_once "../includes/db.php";

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($userId, $dbUsername, $dbPasswordHash, $role);
            $stmt->fetch();

            if (password_verify($password, $dbPasswordHash)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $dbUsername;
                $_SESSION['role'] = $role;

                switch ($role) {
                    case 'admin':
                        header("Location: ../dashboard/admin_dashboard.php");
                        break;
                    case 'teacher':
                        header("Location: ../dashboard/teacher_dashboard.php");
                        break;
                    case 'parent':
                        if (!isset($_SESSION['accepted_terms']) || $_SESSION['accepted_terms'] !== true) {
                            header("Location: ../terms.php");
                        } else {
                            header("Location: ../dashboard/parent_dashboard.php");
                        }
                        break;
                }
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    }
}

// Handle error feedback with SweetAlert
if ($error) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>Swal.fire({icon:'error',title:'Login Failed',text:".json_encode($error)."})</script>";
}
?>
