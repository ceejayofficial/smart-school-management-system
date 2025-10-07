document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('createUserModal'));
    const form = document.getElementById('userForm');
  
    document.querySelectorAll('.edit-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const user = JSON.parse(btn.dataset.user);
        document.getElementById('user-id').value = user.id;
        document.getElementById('user-unique-code').value = user.unique_code;
        document.getElementById('user-username').value = user.username;
        document.getElementById('user-email').value = user.email;
        document.getElementById('user-phone').value = user.phone;
        document.getElementById('user-role').value = user.role;
        document.querySelector('.password-field').style.display = 'none';
        document.getElementById('userModalTitle').textContent = 'Edit User';
        document.getElementById('modal-submit-btn').textContent = 'Update';
        modal.show();
      });
    });
  
    document.querySelector('[data-bs-target="#createUserModal"]').addEventListener('click', () => {
      form.reset();
      document.getElementById('user-id').value = '';
      document.querySelector('.password-field').style.display = 'block';
      document.getElementById('userModalTitle').textContent = 'Create New User';
      document.getElementById('modal-submit-btn').textContent = 'Create';
    });
  
    form.addEventListener('submit', e => {
      e.preventDefault();
      const formData = new FormData(form);
      const isEdit = formData.get('id') !== '';
      fetch(`page/${isEdit ? 'update_user' : 'create_user'}.php`, {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        Swal.fire(data.success ? 'Success' : 'Error', data.message, data.success ? 'success' : 'error')
          .then(() => data.success && location.reload());
      });
    });
  
    document.querySelectorAll('.delete-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const userId = btn.dataset.id;
        Swal.fire({
          title: 'Delete User?',
          text: "This action cannot be undone.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Yes, delete'
        }).then(result => {
          if (result.isConfirmed) {
            fetch('page/delete_user.php', {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ id: userId })
            })
            .then(res => res.json())
            .then(data => {
              Swal.fire(data.success ? 'Deleted!' : 'Error', data.message, data.success ? 'success' : 'error')
                .then(() => data.success && location.reload());
            });
          }
        });
      });
    });
  });
  