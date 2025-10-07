<?php
include("src/dashboard-home/dashboard-home.php");
?>

<head>
  <link rel="stylesheet" href="assets/css/dashboard-home.css">
</head>


<body>
  <div class="container-fluid px-3">
    <?php include("src/dashboard-home/header-section.php"); ?>
    <?php include("src/dashboard-home/profile-icon.php"); ?>
    <?php include("src/dashboard-home/charts-grid.php");    ?>

    <?php include("src/dashboard-home/statistics-cards.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      window.chartData = {
        sms_sent_success: <?= json_encode($sms_sent_success) ?>,
        sms_sent_failed: <?= json_encode($sms_sent_failed) ?>
      };
    </script>
    <script src="assets/js/chart.js"></script>
  </div>
</body>
