document.getElementById('resultsForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const form = e.target;
  const fileInput = form.querySelector('input[name="results_file"]');
  const file = fileInput.files[0];

  if (!file) {
    Swal.fire('Error', 'Please upload an Excel file before submitting.', 'error');
    return;
  }

  const data = await file.arrayBuffer();
  const workbook = XLSX.read(data, { type: 'array' });
  const sheet = workbook.Sheets[workbook.SheetNames[0]];
  const rows = XLSX.utils.sheet_to_json(sheet, { header: 1 });

  const rowCount = rows.length - 1;
  if (rowCount <= 0) {
    Swal.fire('Error', 'The Excel file has no data rows.', 'error');
    return;
  }

  const confirm = await Swal.fire({
    title: 'Are you sure?',
    text: `You are about to send SMS to ${rowCount} ${rowCount === 1 ? 'person' : 'people'}. Proceed?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes, Send',
    cancelButtonText: 'Cancel'
  });

  if (!confirm.isConfirmed) return;

  Swal.fire({
    title: 'Sending Results...',
    didOpen: () => Swal.showLoading()
  });

  try {
    const formData = new FormData(form);
    const response = await fetch('send_results.php', {
      method: 'POST',
      body: formData
    });

    const result = await response.json();
    Swal.close();

    if (result.status === 'success') {
      Swal.fire('Success', result.message, 'success');
      form.reset();
    } else {
      Swal.fire('Error', result.message || 'Sending failed.', 'error');
    }

  } catch (err) {
    Swal.close();
    Swal.fire('Error', 'A network error occurred.', 'error');
  }
});


