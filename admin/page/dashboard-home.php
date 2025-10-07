
<?php
require_once __DIR__ . '/../../db.php'; // DB uses $conn

$user_id = $_SESSION['user_id'] ?? null;

// Default values
$username = '';
$sms_limit = 0;
$sms_used = 0;
$sms_left = 0;
$sms_sent_success = 0;
$sms_sent_failed = 0;
$total_sender_ids = 0;

if ($user_id && isset($conn)) {
  $stmt1 = $conn->prepare("SELECT username FROM users WHERE id = ?");
  if ($stmt1) {
    $stmt1->bind_param("i", $user_id);
    $stmt1->execute();
    $stmt1->bind_result($username_result);
    if ($stmt1->fetch()) {
      $username = $username_result;
    }
    $stmt1->close();
  }
  }

// ✅ Fetch latest total sms_limit and sms_used from the most recent record
$query1 = "SELECT SUM(sms_limit) AS total_limit, SUM(sms_used) AS total_used FROM (
              SELECT sms_limit, sms_used FROM sms_history 
              WHERE id IN (
                SELECT MAX(id) FROM sms_history GROUP BY user_id
              )
          ) AS latest_per_user";

$result1 = $conn->query($query1);
if ($result1 && $row1 = $result1->fetch_assoc()) {
    $sms_limit = (int)$row1['total_limit'];
    $sms_used = (int)$row1['total_used'];
    $sms_left = max(0, $sms_limit - $sms_used);
}

// ✅ Count all sender IDs
$query2 = "SELECT COUNT(*) AS sender_count FROM sender_id";
$result2 = $conn->query($query2);
if ($result2 && $row2 = $result2->fetch_assoc()) {
    $total_sender_ids = (int)$row2['sender_count'];
}

// ✅ Count SMS statuses globally
$query3 = "SELECT status, COUNT(*) AS count FROM sms_history GROUP BY status";
$result3 = $conn->query($query3);
if ($result3) {
    while ($row3 = $result3->fetch_assoc()) {
        $status = strtolower($row3['status']);
        if ($status === 'success') {
            $sms_sent_success = $row3['count'];
        } elseif ($status === 'failed') {
            $sms_sent_failed = $row3['count'];
        }
    }
}


// Totals
$results_sent_total = 0;
$results_sent_success = 0;
$results_sent_failed = 0;

// Count total results sent
$query_total = "SELECT COUNT(*) AS total FROM sms_results";
$result = $conn->query($query_total);
if ($result && $row = $result->fetch_assoc()) {
    $results_sent_total = (int)$row['total'];
}

// Count results by status
$query_status = "SELECT status, COUNT(*) AS count FROM sms_results GROUP BY status";
$result_status = $conn->query($query_status);
if ($result_status) {
    while ($row = $result_status->fetch_assoc()) {
        $status = strtolower($row['status']);
        if ($status === 'success') {
            $results_sent_success = $row['count'];
        } elseif ($status === 'failed') {
            $results_sent_failed = $row['count'];
        }
    }
}




$result_links_count = 0;
$query_links = "SELECT COUNT(*) AS total FROM result_links";
$result2 = $conn->query($query_links);
if ($result2 && $row2 = $result2->fetch_assoc()) {
    $result_links_count = (int)$row2['total'];
}
?>




<head>
  <link rel="stylesheet" href="../assets/css/dashboard-home.css">
</head>


<body>
  <div class="container-fluid px-3">
    <?php include("header-section.php"); ?>
    <?php include("profile-icon.php"); ?>
    <?php include("charts-grid.php");    ?>
    <?php include("statistics-cards.php");    ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      window.chartData = {
        sms_sent_success: <?= json_encode($sms_sent_success) ?>,
        sms_sent_failed: <?= json_encode($sms_sent_failed) ?>
      };
    </script>
    <script src="../assets/js/chart.js"></script>
  </div>
</body>
