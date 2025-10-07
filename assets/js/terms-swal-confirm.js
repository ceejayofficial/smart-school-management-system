// assets/js/swal-confirm.js
document.getElementById('accept-btn')?.addEventListener('click', function () {
    Swal.fire({
      title: 'Confirm Acceptance',
      text: "Do you truly agree to abide by all terms and conditions, including indemnifying the developer from any claims arising from misuse of this platform?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, I Accept',
      cancelButtonText: 'Cancel',
      customClass: {
        confirmButton: 'swal-btn-no-radius btn btn-success me-2',
        cancelButton: 'swal-btn-no-radius btn btn-danger ms-2'
      },
      buttonsStyling: false
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('accept-form')?.submit();
      }
    });
  });
  