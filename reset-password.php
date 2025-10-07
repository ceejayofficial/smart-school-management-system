<?php
session_start();
include("db.php");
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}



$error = '';
$success = '';

if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_pass = trim($_POST['new_password'] ?? '');
  $confirm_pass = trim($_POST['confirm_password'] ?? '');
  
  if (empty($new_pass) || empty($confirm_pass)) {
      $error = "All fields are required.";
  } elseif ($new_pass !== $confirm_pass) {
      $error = "Passwords do not match.";
  } else {
      $user_id = $_SESSION['reset_user_id'];
      $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
  
      $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
      $stmt->bind_param("si", $hashed_pass, $user_id);
  
      if ($stmt->execute()) {
          unset($_SESSION['reset_user_id']);
          header("Location: index.php?reset=success");
          exit();
      } else {
          $error = "Failed to reset password. Try again.";
      }
      $stmt->close();
  }
  
    if (empty($new_pass) || empty($confirm_pass)) {
        $error = "All fields are required.";
    } elseif ($new_pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } else {
        $user_id = $_SESSION['reset_user_id'];
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_pass, $user_id);
        if ($stmt->execute()) {
            unset($_SESSION['reset_user_id']);
            header("Location: index.php?reset=success");
            exit();
        } else {
            $error = "Failed to reset password. Try again.";
        }
        $stmt->close();
    }
}
?>

<?php include("src/auth/reset-header.php"); ?>

<body>

  <div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%; border-radius: 0;">
      <h4 class="mb-3 text-center">Reset Password</h4>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label">New Password</label>
          <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required style="border-radius: 0;" />
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required style="border-radius: 0;" />
        </div>
        <button type="submit" class="btn btn-success w-100" style="border-radius: 0;">Update Password</button>
      </form>
    </div>
  </div>

  <?php if (!empty($error)) : ?>
  <script>
    Swal.fire({
      icon: 'error',
      title: 'Failed',
      text: <?= json_encode($error) ?>
    });
  </script>
  <?php endif; ?>

</body>
</html>
