// Ensure Bootstrap's JavaScript is working for the dropdown on smaller screens
document.addEventListener('DOMContentLoaded', function () {
    var myCollapse = document.getElementById('navbarNav');
    var bsCollapse = new bootstrap.Collapse(myCollapse, {
      toggle: false
    });
    
    // Logout confirmation
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure?',
        text: "You are about to log out. Please confirm if you want to end your session.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, log me out',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'logout.php';
        }
      });
    });
  });