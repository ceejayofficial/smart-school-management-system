<?php
// notification.php
// Usage: include this wherever you want to show error/success messages
if (!empty($message) && !empty($type)) : ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: <?= json_encode($type) ?>, // 'error', 'success', 'info', etc.
            title: <?= json_encode(ucfirst($type)) ?>,
            text: <?= json_encode($message) ?>,
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false
        });
    </script>
<?php endif; ?>
