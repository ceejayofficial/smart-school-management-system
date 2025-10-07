<?php

if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection
require_once __DIR__ . '/../db.php';

$userId = $_SESSION['user_id'];
?>

<!-- RESULTS FORM PAGE -->
<div class="container-fluid px-4 py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-12 col-lg-10">
      <form id="resultsForm" enctype="multipart/form-data" class="p-4 bg-white shadow-sm rounded">

        <!-- Sender ID -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Sender ID</label>
          <select class="form-select" name="sender_id" required>
            <option value="">Select Sender ID</option>
            <?php
            $stmt = $conn->prepare("SELECT sender_name FROM sender_id WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
              $name = htmlspecialchars($row['sender_name']);
              echo "<option value=\"$name\">$name</option>";
            }
            $stmt->close();
            ?>
          </select>
        </div>

        <!-- Upload Excel File -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Upload Excel File (.xlsx)</label>
          <input type="file" class="form-control" name="results_file" accept=".xlsx" required>
          <div class="form-text text-muted" style="max-width: 800px;"> <br>
            <p>
              The uploaded Excel file must include the following column headers in the first row and must follow the exact arrangement below:
              <strong>PARENT_NUMBER</strong>, <strong>SEMESTER</strong>, <strong>STUDENT_NAME</strong>, <strong>PROGRAMME</strong> (optional), and any number of subject columns such as <strong>ENGLISH</strong>, <strong>MATH</strong>, <strong>SCIENCE</strong>, etc.
            </p>

            <p>
              Do not rearrange the columns or rename them incorrectly. The order must remain as listed for the system to process the data accurately.
              Each row will be processed to generate an SMS containing the student's results. The message will be sent directly to the parent's phone number provided in the <strong>PARENT_NUMBER</strong> column.

            </p>

            <!-- <p class="mb-2"><strong>Example message:</strong></p>
            <code class="d-block mb-2">
              Hi, your ward Kofi Mensah pursuing General Arts's results for 2024 Term 2 are:
              ENGLISH: 78
              MATH: 85
              SCIENCE: 90
            </code>

            <code class="d-block mb-3">
              Hi, your ward Ama Boateng's results for 2024 Term 2 are:
              MATHS: 85
              ENGLISH: 78
              SCIENCE: 90
            </code> -->
            <div class="d-flex justify-content-between flex-wrap gap-3">
              <div>
                <a href="sample_results_basic.xlsx" download class="btn btn-outline-dark btn-sm mb-1">
                  Basic School Template
                </a><br>
                <small class="text-muted">Use this as a guide for basic schools (no programme column)</small>
              </div>

              <div>
                <a href="sample_results_shs.xlsx" download class="btn btn-outline-dark btn-sm mb-1">
                  Higher Education Template
                </a><br>
                <small class="text-muted">Use this as a guide for SHS or tertiary (includes programme column)</small>
              </div>
            </div>

          </div>

        </div>

        <!-- Submit -->
        <button type="submit" class="btn border btn-success w-100 mt-3" style="background-color: #1f2937">
          Send Results
        </button>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="assets/js/send_results.js"></script>
