<?php
  include('free_sms_display.php');

?>

<div class="row gx-4 gy-4 pt-4">
  <!-- Sender IDs -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border shadow-sm">
      <div class="card-body">
        <div class="stat-title">Senders</div>
        <div class="stat-value text-warning"><?= $total_sender_ids ?></div>
        <div class="stat-subtext">Approved sender names</div>
      </div>
    </div>
  </div>

  <!-- SMS Loaded -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border shadow-sm">
      <div class="card-body">
        <div class="stat-title">SMS</div>
        <div class="stat-value text-success"><?= $sms_limit ?></div>
        <div class="stat-subtext">Your plan's message quota</div>
      </div>
    </div>
  </div>

<!-- SMS Left -->
<div class="col-12 col-md-12 col-lg-4">
  <div class="card card-stat border shadow-sm">
    <div class="card-body">
      <div class="stat-title">Remaining</div>
      <div class="stat-value <?= $is_free_credit ? 'text-info' : 'text-success' ?>">
        <?= $is_free_credit ? '1 Free Credit' : htmlspecialchars($sms_left) ?>
      </div>
      <div class="stat-subtext">
        <?= $is_free_credit ? 'Free initial message assigned' : 'Remaining messages' ?>
      </div>
    </div>
  </div>
</div>

</div>