
<?php include("src/create-sender/create-sender-logic.php"); ?>

<link rel="stylesheet" href="assets/css/create-sender.css">


<?php
// Ensure session is started and DB is connected
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'db.php';

$user_id = $_SESSION['user_id'] ?? null;

// Get user's current sender count
$stmt1 = $conn->prepare("SELECT COUNT(*) as total FROM sender_id WHERE user_id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$totalSender = $stmt1->get_result()->fetch_assoc()['total'] ?? 0;
$stmt1->close();

// Get user limit
$stmt2 = $conn->prepare("SELECT `limit` FROM users WHERE id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$userLimit = $stmt2->get_result()->fetch_assoc()['limit'] ?? 3;
$stmt2->close();

$formDisabled = $totalSender >= $userLimit;
?>

<div class="container-fluid px-4 px-md-5">
  <div class="mx-auto" style="max-width: 100%;">

    <!-- Sender Creation Form -->
    <div class="bg-white p-4 rounded mb-5">
    <?php if ($formDisabled): ?>
  <div class="alert alert-success mb-4">
    You have reached your sender ID limit (<?= $userLimit ?>). Contact admin 
  </div>
<?php endif; ?>


      <form id="senderForm" <?= $formDisabled ? 'class="d-none"' : '' ?>>
        <div class="row">
          <div class="mb-3 col-md-6">
            <label class="form-label fw-semibold">Sender Name</label>
            <input type="text" name="sender_name" class="form-control" maxlength="11" required placeholder="e.g. GHANA">
            <small class="text-muted">Max 11 characters. Letters and numbers only.</small>
          </div>
          <div class="mb-3 col-md-6">
            <label class="form-label fw-semibold">Purpose</label>
            <input type="text" name="purpose" class="form-control" required placeholder="e.g. SMS Campaigns">
          </div>
        </div>
        <button type="submit" style="background-color: #1f2937;" class="btn text-white w-100 mt-3">Submit</button>
      </form>
    </div>

    <!-- Sender ID List -->
    <div class="mt-5 bg-white p-4 rounded ">
      <h5 class="mb-3">Senders</h5>
      <p class="text-muted small">Showing <?= min($limit, $total - $offset) ?> of <?= $total ?> records</p>

      <?php if (!empty($senderData)): ?>
        <div class="d-flex flex-column gap-3">
          <?php foreach ($senderData as $sender): 
            $status = getSenderStatus($sender['sender_name']);
            $statusNormalized = strtolower(trim($status));
            $circleClass = match (true) {
              str_contains($statusNormalized, 'approved'), str_contains($statusNormalized, 'success') => 'circle-success',
              str_contains($statusNormalized, 'pending') => 'circle-warning',
              str_contains($statusNormalized, 'rejected'), str_contains($statusNormalized, 'declined'), str_contains($statusNormalized, 'failed') => 'circle-danger',
              default => 'circle-default'
            };
          ?>
          <div class=" p-3 rounded w-100 sender-card" data-id="<?= $sender['id'] ?>">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
              <!-- Left: Sender Info -->
              <div>
                <div class="fs-5 fw-semibold"><?= htmlspecialchars($sender['sender_name']) ?></div>
                <div class="text-muted small"><?= htmlspecialchars($sender['purpose']) ?></div>
                <small class="text-secondary">Created on <?= date("M d, Y", strtotime($sender['created_at'])) ?></small>
              </div>

              <!-- Center: Status -->
              <div class="d-flex align-items-center gap-2 mx-auto">
                <span class="circle-indicator <?= $circleClass ?>"></span>
                <span class="text-capitalize small text-muted"><?= htmlspecialchars($status) ?></span>
              </div>

              <!-- Right: Delete Button -->
              <div>
                <button class="btn btn-sm btn-danger delete-sender" data-id="<?= $sender['id'] ?>">
                  <i class="bi bi-trash"></i> Delete
                </button>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted small">No sender IDs found.</p>
      <?php endif; ?>
    </div>

  </div>
</div>


      <!-- ✅ Pagination -->
      <nav class="mt-4">
        <ul class="pagination justify-content-center">
          <?php for ($p = 1; $p <= $totalPages; $p++): ?>
            <li class="page-item <?= $p == $pageNumber ? 'active' : '' ?>">
              <a class="page-link <?= $p == $pageNumber ? 'text-white' : '' ?>" href="?page=create-sender-form&p=<?= $p ?>" style="background-color: #1f2937;">
                <?= $p ?>
              </a>
            </li>
          <?php endfor; ?>
        </ul>
      </nav>
    </div>


  </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js/create-sender-form.js"></script>

<?php include("./components/loader.php"); ?>