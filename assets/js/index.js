document.addEventListener("DOMContentLoaded", function () {
    const feedback = window.loginFeedback || {};
  
    if (feedback.error) {
      Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: feedback.error,
        confirmButtonColor: '#dc3545'
      });
    }
  
    if (feedback.resetSuccess) {
      Swal.fire({
        icon: 'success',
        title: 'Password Reset',
        text: 'You can now log in with your new password.',
        confirmButtonColor: '#28a745'
      });
    }
  });
  