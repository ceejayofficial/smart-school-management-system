<?php
session_start();
include("../../../db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $dbUsername, $dbPassword, $role);
        $stmt->fetch();

        if ($password === $dbPassword) {
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $dbUsername;
            $_SESSION['role'] = $role;

            if ($role === 'admin') {
                header("Location: ../../../admin/index.php");
            } else {
                if (!isset($_SESSION['accepted_terms']) || $_SESSION['accepted_terms'] !== true) {
                    header("Location: ../../../terms.php");
                } else {
                    header("Location: ../../../dashboard.php");
                }
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: ../../../index.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: ../../../index.php");
        exit();
    }
}
?>



<?php if (!empty($error)) : ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Login Failed',
      text: <?= json_encode($error) ?>
    });
  </script>
  <?php endif; ?>

  <?php
if (isset($_GET['reset']) && $_GET['reset'] === 'success') {
    echo "<script>
      Swal.fire({
        icon: 'success',
        title: 'Password Reset',
        text: 'You can now log in with your new password.'
      });
    </script>";
}
?>
