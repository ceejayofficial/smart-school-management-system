
  document.getElementById('senderForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const sender_name = e.target.sender_name.value.trim();
    const purpose = e.target.purpose.value.trim();

    if (!sender_name || !purpose) {
      return Swal.fire('Error', 'Please fill all fields.', 'warning');
    }

    if (!/^[a-zA-Z0-9]+$/.test(sender_name)) {
      return Swal.fire('Invalid', 'Sender name must be alphanumeric.', 'error');
    }

    if (sender_name.length > 11) {
      return Swal.fire('Invalid', 'Sender name must not exceed 11 characters.', 'error');
    }

    Swal.fire({
      title: 'Registering...',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    try {
      const res = await fetch('create_sender.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          sender_name,
          purpose
        })
      });

      const data = await res.json();
      Swal.close();

      if (data.status === 'success') {
        Swal.fire('Success', `Sender ID '${sender_name}' was successfully created.`, 'success')
          .then(() => window.location.reload());
      } else {
        const msg = data.message || data?.mnotify_response?.message || 'Registration failed.';
        Swal.fire('Failed', msg, 'error');
      }
    } catch (err) {
      Swal.close();
      Swal.fire('Network Error', 'Could not connect', 'error');
      console.error(err);
    }
  });


  document.querySelectorAll('.delete-sender').forEach(button => {
    button.addEventListener('click', function() {
      const senderId = this.dataset.id;
      const card = this.closest('.sender-card');

      Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this sender ID!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(`pages/delete_sender.php?id=${senderId}`, {
            method: 'GET'
            })
            .then(res => res.text())
            .then(data => {
              if (data.trim() === 'success') {
                Swal.fire('Deleted!', 'Sender ID has been deleted.', 'success');
                card.remove();
              } else {
                Swal.fire('Error!', data, 'error');
              }
            })
            .catch(err => {
              Swal.fire('Error!', 'Something went wrong.', 'error');
            });
        }
      });
    });
  });



  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('senderForm');
    if (form && form.classList.contains('disabled-form')) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        alert("You’ve reached your sender ID limit.");
      });
    }
  });
