document.getElementById("senderForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
  
    fetch("crud/add.php", {
      method: "POST",
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      Swal.fire({
        icon: data.success ? 'success' : 'error',
        title: data.success ? 'Added!' : 'Error',
        text: data.message
      }).then(() => {
        if (data.success) window.location.reload();
      });
    })
    .catch(() => {
      Swal.fire('Error', 'Could not connect to server.', 'error');
    });
  });
  
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`crud/delete.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
              Swal.fire(data.success ? 'Deleted!' : 'Error', data.message, data.success ? 'success' : 'error')
                .then(() => {
                  if (data.success) document.getElementById(`row-${id}`).remove();
                });
            });
        }
      });
    });
  });
  