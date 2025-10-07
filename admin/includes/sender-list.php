<?php if (count($senders) > 0): ?>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Sender Name</th>
                    <th>Purpose</th>
                    <th>User ID</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($senders as $index => $sender): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($sender['sender_name']) ?></td>
                        <td><?= htmlspecialchars($sender['purpose'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($sender['user_id']) ?></td>
                        <td><?= htmlspecialchars($sender['created_at']) ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-sender"
                                data-id="<?= $sender['id'] ?>"
                                data-user="<?= $sender['user_id'] ?>">
                                Delete
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-muted mt-4">No senders found<?= $user_id ? ' for this user.' : '.' ?></p>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-sender').forEach(button => {
    button.addEventListener('click', () => {
        const id = button.dataset.id;

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the sender name",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('crud/delete.php?id=' + id)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error('Server error');
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', 'Sender has been deleted.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message || 'Delete failed.', 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error', 'Could not connect to server.', 'error');
                        console.error(err);
                    });
            }
        });
    });
});
</script>

