<?php
require_once 'db.php';
include("header.php");
include("src/view-result/view-result-logic.php"); // Gets $result and $school_name
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $school_name; ?> - Academic Report</title>
    <link rel="stylesheet" href="assets/css/view-result.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Font: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body>

<div class="container-fluid px-3 px-md-5 py-4">

    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        
        <!-- Left: Text Content -->
        <div class="text-start">
            <h2 class="fw-bold text-uppercase mb-1"><?php echo $school_name; ?> Results</h2>
            <h4 class="mb-2">Academic Report</h4>
            <p class="text-muted mb-2">This report represents the record for the term.</p>

            <!-- ✅ Print Button -->
            <button onclick="window.print()" class="btn btn-sm" style="background-color: transparent; border: 1px solid black; color: black; border-radius: 0;">
                🖨️ Print
            </button>
        </div>

        <!-- Right: Rounded Logo -->
        <div class="text-center">
            <?php
            $brandingLogo = null;
            if (isset($_SESSION['user_id'])) {
                $uid = $_SESSION['user_id'];
                $stmt = $conn->prepare("SELECT logo FROM branding WHERE user_id = ?");
                $stmt->bind_param("i", $uid);
                $stmt->execute();
                $res = $stmt->get_result()->fetch_assoc();
                if ($res && !empty($res['logo'])) {
                    $brandingLogo = $res['logo'];
                }
            }

            if ($brandingLogo): ?>
                <img src="data:image/png;base64,<?= base64_encode($brandingLogo) ?>"
                     alt="User Logo"
                     class="img-fluid"
                     style="max-width: 80px; height: auto; object-fit: cover; border-radius: 50%; border: 2px solid #ccc;">
                     <?php else: ?>
        <div class="d-flex align-items-center justify-content-center"
             style="width:80px; height:80px; border-radius:50%; border:2px solid #ccc; background:#f8f9fa; margin:0 auto;">
             <svg xmlns="http://www.w3.org/2000/svg" 
       viewBox="0 0 16 16" 
       fill="currentColor" 
       class="img-fluid border p-2 text-muted" 
       style="max-height:150px; width:auto;">
    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 
      11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 
      2.37A7 7 0 0 0 8 1"/>
  </svg>        </div>
    <?php endif; ?>
        </div>
    </div>

    <!-- Results Cards -->
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body text-dark">
                <h4 class="card-title fw-bold"><?php echo htmlspecialchars($row['student_name']); ?></h4>
                <p><strong>Semester:</strong> <?php echo htmlspecialchars($row['semester']); ?></p>

                <?php
                    $lines = explode("\n", $row['message']);
                    $subject_marks = [];

                    foreach ($lines as $line) {
                        if (strpos($line, ':') !== false) {
                            [$subject, $mark] = explode(':', $line, 2);
                            $subject = trim($subject);
                            $mark = trim($mark);

                            if ($subject && $mark && stripos($subject, 'view') === false) {
                                $subject_marks[] = ['subject' => $subject, 'mark' => $mark];
                            }
                        }
                    }
                ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th class="text-center">Mark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subject_marks as $entry): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($entry['subject']); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($entry['mark']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

    <!-- Note -->
    <div class="alert alert-light mt-4 text-dark border">
        <strong>NB:</strong> For inquiries, please contact the school administration.
    </div>

</div>

</body>
</html>
