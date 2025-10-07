document.getElementById('smsForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  Swal.fire({
    title: 'Sending...',
    text: 'Please wait while we process your request.',
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  try {
    const response = await fetch('send_sms.php', {
      method: 'POST',
      body: formData
    });

    const result = await response.json();
    Swal.close();

    if (result.status === 'success') {
      Swal.fire({
        icon: 'success',
        title: 'Messages Sent Successfully!',
        html: result.html,
        width: 700
      });
      form.reset();
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: result.message || 'An error occurred while sending messages.'
      });
    }
  } catch (error) {
    Swal.close();
    Swal.fire({
      icon: 'error',
      title: 'Unexpected Error',
      text: 'Failed to connect to the server. Please try again.'
    });
  }
});