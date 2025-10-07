<?php include("profile-logic.php"); ?>

<?php if ($user): ?>
  <div class="p-3 mb-4" style="max-width: 700px;">
    <div class="d-flex align-items-start gap-3 mb-3">
      <!-- Profile Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#198754" viewBox="0 0 24 24">
        <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10zm0 12c-4.97 0-9 2.16-9 5v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-1c0-2.84-4.03-5-9-5z" />
      </svg>

      <div>
        <h5 class="fw-semibold mb-1 text-dark">Hi, <?= htmlspecialchars($user['username']) ?></h5>
        <small class="text-muted">Profile overview</small>
      </div>
    </div>

    <div class="border-top pt-3">
      <div class="row mb-2">
        <div class="col-sm-4 text-muted">Email</div>
        <div class="col-sm-8"><?= htmlspecialchars($user['email']) ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-4 text-muted">Phone</div>
        <div class="col-sm-8"><?= htmlspecialchars($user['phone']) ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-4 text-muted">Role</div>
        <div class="col-sm-8"><?= ucfirst($user['role']) ?></div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-4 text-muted">User Code</div>
        <div class="col-sm-8" id="userCodeText"><?= htmlspecialchars($user['unique_code']) ?></div>
      </div>
      <div class="row mb-3">
        <div class="col-sm-4 text-muted">Joined</div>
        <div class="col-sm-8"><?= date('F j, Y', strtotime($user['created_at'])) ?></div>
      </div>

<!-- Print Button + Note aligned to left -->
<!-- <div class="text-start mt-4 pt-2 border-top">
  <button onclick="printUserCodeCard('<?= htmlspecialchars($user['username']) ?>', '<?= htmlspecialchars($user['unique_code']) ?>')" class="btn btn-outline-success btn-sm">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
      <path d="M2 7a2 2 0 0 0-2 2v3a1 1 0 0 0 1 1h1v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-2h1a1 1 0 0 0 1-1V9a2 2 0 0 0-2-2H2zm10 5H4v3h8v-3z"/>
      <path d="M5 1a1 1 0 0 0-1 1v4h8V2a1 1 0 0 0-1-1H5z"/>
    </svg>
    Print User Code
  </button>
  <small class="d-block text-muted mt-2">
    Save this user code for password reset and wallet loading.
  </small>
</div> -->


<script src="../assets/js/user-id-print.js"></script>


<?php else: ?>
  <div class="alert alert-danger">User not found or not logged in.</div>
<?php endif; ?>
