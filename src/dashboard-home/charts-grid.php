
<head>
  <link rel="stylesheet" href="assets/css/performance.css">
</head>
<div class="card card-stat border-1 ">
  <div class="card-body row g-4 justify-content-center">

    <!-- SMS Sent Summary -->
    <div class="col-12 col-md-6 col-lg-3 d-none d-md-block">
      <div class="stat-title">SMS Sent</div>
      <div class="stat-value text-success"><?= $sms_sent_success ?></div>
      <div class="stat-subtext text-muted">All quick messages</div>
    </div>
    <div class="col-12 col-md-8 col-lg-3 text-center">
  <div style="border: 1px solid #ccc; padding: 0.5rem; min-height: 200px; ">
    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
      <svg viewBox="0 0 36 36" class="circular-chart green" width="200" height="200">
        <path class="circle-bg"
              d="M18 2.0845
                 a 15.9155 15.9155 0 0 1 0 31.831
                 a 15.9155 15.9155 0 0 1 0 -31.831" />
        <path id="systemCircle" class="circle"
              stroke-dasharray="95, 100"
              d="M18 2.0845
                 a 15.9155 15.9155 0 0 1 0 31.831
                 a 15.9155 15.9155 0 0 1 0 -31.831" />
        <text x="18" y="20.35" class="percentage" id="systemPercent">95%</text>
      </svg>
      <div class="mt-2 text-muted small">System Performance</div>
    </div>
  </div>
</div>



    <!-- Chart 2: SMS History -->
    <div class="col-12 col-md-8 col-lg-3 text-center">
      <div style="border: 1px solid #ccc; padding: 0.5rem;">
        <canvas id="chartPie2" style="max-width: 200px; width: 100%; height: auto; margin: 0 auto;"></canvas>
        <div class="mt-2 text-muted small">SMS History</div>
      </div>
    </div>

    <!-- Chart 3: Logs -->
    <div class="col-12 col-md-8 col-lg-3 text-center">
      <div style="border: 1px solid #ccc; padding: 0.5rem;">
        <canvas id="chartDoughnut3" style="max-width: 200px; width: 100%; height: auto; margin: 0 auto;"></canvas>
        <div class="mt-2 text-muted small">SMS Logs</div>
      </div>
    </div>

  </div>
</div>
<script src="assets/js/performance.js"></script>
