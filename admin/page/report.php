<!-- SweetAlert + Button Section -->
<div class="text-start my-2 ps-3 p-2">
  <p class="mt-3 text-muted" style="max-width: 700px;">
    These reports help you track your SMS performance and academic communication efficiency over time.
    Both will be downloaded as Excel files and contain relevant data to monitor progress.
  </p>
  <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
    <!-- SMS History Report Button -->
    <button id="generateReportBtn" class="btn btn-success btn-md px-5 py-3 fw-bold">
       Download SMS Report
    </button>

    <!-- SMS Results Report Button -->
    <button id="generateResultsBtn" class="btn btn-primary btn-md px-5 py-3 fw-bold">
    Download Results Report
    </button>
  </div>

  
</div>


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // SMS Report
  document.getElementById('generateReportBtn').addEventListener('click', function () {
    Swal.fire({
      title: 'Generate SMS Report?',
      text: "This will download your recent SMS history.",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, generate it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Generating...',
          text: 'Your report is being downloaded',
          icon: 'success',
          timer: 1800,
          showConfirmButton: false,
          willClose: () => {
            window.location.href = 'src/generate-report/generate_sms_report.php';
          }
        });
      }
    });
  });

  // SMS Results Report
  document.getElementById('generateResultsBtn').addEventListener('click', function () {
    Swal.fire({
      title: 'Generate Results Report?',
      text: "This will download recent SMS results data",
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, generate it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Generating...',
          text: 'Your report is being downloaded',
          icon: 'success',
          timer: 1800,
          showConfirmButton: false,
          willClose: () => {
            window.location.href = 'src/generate-report/generate_sms_results_report.php';
          }
        });
      }
    });
  });
</script>
