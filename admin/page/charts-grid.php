<div class="row gx-4 gy-4">
  <!-- Sent -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Sent</div>
        <div class="stat-value text-success"><?= $sms_sent_success ?></div>
        <div class="stat-subtext">All quick messages</div>
      </div>
    </div>
  </div>

  <!-- Loaded -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Loaded</div>
        <div class="stat-value text-success"><?= $sms_limit ?></div>
        <div class="stat-subtext">Your plan's message quota</div>
      </div>
    </div>
  </div>

  <!-- Remaining -->
  <div class="col-12 col-md-12 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Remaining</div>
        <div class="stat-value text-success">
          <?= ($sms_left == 0) ? '<span class="text-danger stat-value">Contact admin</span>' : $sms_left ?>
        </div>
        <div class="stat-subtext">Remaining messages</div>
      </div>
    </div>
  </div>
</div>
