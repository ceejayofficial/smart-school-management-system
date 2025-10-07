<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT sms_limit, sms_used FROM sms_history WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($sms_limit, $sms_used);
$stmt->fetch();
$stmt->close();

$sms_limit = $sms_limit ?? 0;
$sms_used = $sms_used ?? 0;
$sms_balance = max(0, $sms_limit - $sms_used);
?>

<head>
<link rel="stylesheet" href="assets/css/wallet.css">
</head>
<body>
  <div class="container py-5">

    <div class="row gy-4">
      <!-- SMS Limit -->
      <div class="col-12">
        <div class="wallet-card">
          <div class="wallet-title">SMS</div>
          <div class="wallet-value text-success"><?= number_format($sms_limit) ?></div>
        </div>
      </div>

      <!-- SMS Used -->
      <div class="col-12">
        <div class="wallet-card">
          <div class="wallet-title">Used</div>
          <div class="wallet-value text-warning"><?= number_format($sms_used) ?></div>
        </div>
      </div>

      <!-- SMS Balance -->
      <div class="col-12">
        <div class="wallet-card">
          <div class="wallet-title">Remaining</div>
          <div class="wallet-value <?= $sms_balance == 0 ? 'text-danger' : 'text-success' ?>">
            <?= number_format($sms_balance) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
