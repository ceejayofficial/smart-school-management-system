<?php
ob_start();

$userId = $_SESSION['user_id'] ?? null;
$user = null;
$branding = null;
$errorMsg = null;
$success = false;

if ($userId) {
    // Fetch user
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Handle upload before fetching branding
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo'])) {
        // Catch PHP ini upload error first
        if ($_FILES['logo']['error'] === UPLOAD_ERR_INI_SIZE) {
            $errorMsg = "Logo must not exceed 1MB";
        } else {
            $fileSize = $_FILES['logo']['size'];

            if ($fileSize > 1048576) { // 1MB limit
                $errorMsg = "Logo must not exceed 1MB.";
            } elseif ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
                $errorMsg = "File upload error. Please try again.";
            } else {
                $logoData = file_get_contents($_FILES['logo']['tmp_name']);

                // Check if record exists
                $stmt = $conn->prepare("SELECT id FROM branding WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $exists = $stmt->get_result()->fetch_assoc();

                if ($exists) {
                    // Update logo
                    $stmt = $conn->prepare("UPDATE branding SET logo = ? WHERE user_id = ?");
                    $stmt->bind_param("si", $logoData, $userId);
                } else {
                    // Insert new logo
                    $stmt = $conn->prepare("INSERT INTO branding (logo, user_id) VALUES (?, ?)");
                    $stmt->bind_param("si", $logoData, $userId);
                }

                $stmt->send_long_data(0, $logoData);
                $stmt->execute();

                $success = true; // flag for swal
            }
        }
    }

    // Fetch branding (AFTER possible upload)
    $stmt = $conn->prepare("SELECT logo FROM branding WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $branding = $stmt->get_result()->fetch_assoc();
}
?>

<?php if ($user): ?>
  <div class="p-3 mb-4" style="max-width: 700px; background-color: #ffffff;">
    <div class="d-flex align-items-start gap-3 mb-3">
      <h5 class="fw-semibold mb-1 text-dark">Hi, <?= htmlspecialchars($user['username']) ?></h5>
    </div>

    <!-- Show Existing Logo -->
    <div class="mb-3">
      <?php if (!empty($branding['logo'])): ?>
        <img src="data:image/png;base64,<?= base64_encode($branding['logo']) ?>" 
             alt="User Logo" 
             class="img-fluid border p-2" style="max-height:150px;">
      <?php else: ?>
        <svg xmlns="http://www.w3.org/2000/svg" 
             viewBox="0 0 16 16" 
             fill="currentColor" 
             class="img-fluid border p-2 text-muted" 
             style="max-height:150px; width:auto;">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 
            11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 
            2.37A7 7 0 0 0 8 1"/>
        </svg>
      <?php endif; ?>
    </div>

    <!-- Upload Form -->
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label fw-semibold">Upload/Replace Logo</label>
        <input type="file" name="logo" accept="image/*" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Save</button>
    </form>
  </div>
<?php else: ?>
  <div class="alert alert-danger">User not found or not logged in.</div>
<?php endif; ?>


<!-- SweetAlert Messages -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (!empty($errorMsg)): ?>
<script>
Swal.fire({
  icon: 'error',
  title: 'Upload Failed',
  text: '<?= $errorMsg ?>'
});
</script>
<?php elseif ($success): ?>
<script>
Swal.fire({
  icon: 'success',
  title: 'Logo uploaded successfully!',
  showConfirmButton: false,
  timer: 1500
}).then(() => {
  window.location.href = '<?= $_SERVER['PHP_SELF'] ?>';
});
</script>
<?php endif; ?>

<?php ob_end_flush(); ?>
