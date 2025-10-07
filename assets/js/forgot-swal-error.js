
document.addEventListener('DOMContentLoaded', function () {
  const errorInput = document.getElementById('swal-error-msg');

  if (errorInput && errorInput.value.trim() !== "") {
    Swal.fire({
      icon: 'error',
      title: 'Failed',
      text: errorInput.value,
      confirmButtonColor: '#dc3545'
    });
  }
});
