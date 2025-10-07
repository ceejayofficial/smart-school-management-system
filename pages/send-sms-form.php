<?php

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: ../index.php");
  exit();
}

require __DIR__ . '/../vendor/autoload.php'; // Correct path to Composer autoload

use Dotenv\Dotenv;

// Load .env from root directory
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection
require_once __DIR__ . '/../db.php';

$userId = $_SESSION['user_id'];
?>

<!-- FULL WIDTH FORM SECTION -->
<div class="container-fluid px-4 py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-12 col-lg-12"> <!-- Adjust width on larger screens -->
      <form id="smsForm" enctype="multipart/form-data" class="p-4 bg-white shadow-sm rounded">

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

        <!-- Message -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Message</label>
          <textarea class="form-control" name="message" rows="4" placeholder="Enter your message here..." required></textarea>
        </div>

        <!-- Delivery Method -->
        <div class="mb-3">
          <label class="form-label fw-semibold">Delivery Method</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="inputMethod" id="manualInput" value="manual" checked>
            <label class="form-check-label" for="manualInput">Enter Phone</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="inputMethod" id="fileInput" value="file">
            <label class="form-check-label" for="fileInput">Upload File</label>
          </div>
        </div>

        <!-- Manual Input -->
        <div class="mb-3" id="manualInputField">
          <label class="form-label">Phone Numbers (comma-separated)</label>
          <textarea class="form-control" name="phone_numbers" rows="3" placeholder="e.g. 0550000000,0240000000"></textarea>
        </div>

        <!-- File Input -->
        <div class="mb-3 d-none" id="fileInputField">
          <label class="form-label">Upload Excel File (.xlsx)</label>
          <input type="file" class="form-control" name="contacts_file" accept=".xlsx">
        </div>

        <!-- Submit -->
        <button type="submit" class="btn border btn-success w-100 mt-3" style="background-color: #1f2937">
          Submit
        </button>
      </form>
    </div>
  </div>
</div>

<!-- Script for toggling input fields -->
<script>
  document.querySelectorAll('input[name="inputMethod"]').forEach(radio => {
    radio.addEventListener('change', function () {
      const manualField = document.getElementById('manualInputField');
      const fileField = document.getElementById('fileInputField');

      if (this.value === 'manual') {
        manualField.classList.remove('d-none');
        fileField.classList.add('d-none');
      } else {
        manualField.classList.add('d-none');
        fileField.classList.remove('d-none');
      }
    });
  });

  // Form submit handler
  document.getElementById('smsForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    Swal.fire({ title: 'Sending...', didOpen: () => Swal.showLoading() });

    try {
      const response = await fetch('send_sms.php', {
        method: 'POST',
        body: formData
      });
      const result = await response.json();
      Swal.close();

      if (result.status === 'success') {
        Swal.fire('Success', result.message, 'success');
        form.reset();
      } else {
        Swal.fire('Error', result.message || 'Sending failed', 'error');
      }
    } catch (err) {
      Swal.close();
      Swal.fire('Error', 'Network error occurred', 'error');
    }
  });
</script>
