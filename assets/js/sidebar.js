
  const sidebar = document.getElementById("mainSidebar");
  const toggleBtn = document.getElementById("sidebarToggle");
  const toggleIcon = document.getElementById("toggleIcon");

  toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("show");
    const isOpen = sidebar.classList.contains("show");
    toggleIcon.textContent = isOpen ? '✕' : '☰';
    toggleIcon.style.color = isOpen ? '#fff' : '#000';
  });

  document.getElementById('logoutBtn').addEventListener('click', function() {
    Swal.fire({
      title: 'Do you want to logout?',
      text: "This will end your program and activities",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'logout.php';
      }
    });
  });
