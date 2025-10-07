<div class="row gx-4 gy-4 pt-4">
  <!-- Sender IDs -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Senders</div>
        <div class="stat-value text-warning"><?= $total_sender_ids ?></div>
        <div class="stat-subtext">Assigned sender names</div>
      </div>
    </div>
  </div>

  <!-- Results Link Sent -->
  <div class="col-12 col-md-6 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Links</div>
        <div class="stat-value text-success"><?= $result_links_count ?></div>
        <div class="stat-subtext">Via result links</div>
      </div>
    </div>
  </div>

  <!-- Results Sent -->
  <div class="col-12 col-md-12 col-lg-4">
    <div class="card card-stat border rounded shadow-sm">
      <div class="card-body">
        <div class="stat-title">Results</div>
        <div class="stat-value text-success">
          <?= $results_sent_total ?>
        </div>
        <div class="stat-subtext">
          <span class="text-success">Success: <?= $results_sent_success ?></span> &nbsp; | &nbsp;
          <span class="text-danger">Failed: <?= $results_sent_failed ?></span>
        </div>
      </div>
    </div>
  </div>
</div>
