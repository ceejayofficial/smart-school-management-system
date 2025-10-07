<?php
require_once '../db.php';
include_once 'includes/update_handler.php';
include_once 'includes/load_logic.php';
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php if ($swal_message): ?>
    <input type="hidden" id="swal_type" value="<?= $swal_type ?>">
    <input type="hidden" id="swal_message" value="<?= htmlspecialchars($swal_message) ?>">
    <input type="hidden" id="swal_user_code" value="<?= htmlspecialchars($_GET['user_id'] ?? '') ?>">
<?php endif; ?>

<div class="container mt-4">
    <h2 class="mb-4">Load Wallet</h2>

    <form method="GET" action="dashboard.php" class="mb-4">
        <input type="hidden" name="page" value="load">
        <div class="input-group">
            <input type="text" name="user_id" class="form-control" placeholder="Enter User Code (e.g. USR00003)" value="<?= htmlspecialchars($_GET['user_id'] ?? '') ?>" required>
            <button class="btn btn-dark">Search</button>
        </div>
    </form>

    <?php if ($found_user): ?>
        <div class="alert alert-success">
            <p><?= htmlspecialchars($found_user['username']) ?></p>
            <p><?= htmlspecialchars($found_user['email']) ?></p>
            <p><?= htmlspecialchars($found_user['phone']) ?></p>
            <p><strong>Wallet:</strong> <?= (int)$highest_limit ?></p>
            <p><strong>Used:</strong> <?= (int)$total_sms_used ?></p>
        </div>

        <form method="POST" action="dashboard.php?page=load&user_id=<?= htmlspecialchars($_GET['user_id']) ?>" class="mb-5">
            <input type="hidden" name="user_id" value="<?= $found_user['id'] ?>">
            <div class="mb-3">
                <input type="number" name="new_limit" class="form-control" placeholder="Enter Number" required>
            </div>
            <button type="submit" name="update_limit" class="btn btn-success">Load Wallet</button>
        </form>

        <h4><?= htmlspecialchars($found_user['username']) ?>, Wallet History</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead>
                    <tr>
                        <th>Recipient</th>
                        <th>Status</th>
                        <th>SMS Limit</th>
                        <th>SMS Used</th>
                        <th>Sent At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sms_history)): ?>
                        <?php foreach ($sms_history as $sms): ?>
                            <tr>
                                <td><?= htmlspecialchars($sms['recipient']) ?></td>
                                 <td><?= htmlspecialchars($sms['status']) ?></td>
                                <td><?= htmlspecialchars($sms['sms_limit']) ?></td>
                                <td><?= htmlspecialchars($sms['sms_used']) ?></td>
                                <td><?= htmlspecialchars($sms['sent_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">No Wallet history</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php elseif (isset($_GET['user_id'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'User not found!',
                text: 'No user found with the code: <?= htmlspecialchars($_GET['user_id']) ?>',
            });
        </script>
    <?php endif; ?>
</div>

</body>

<script src="../assets/js/load.js" defer></script>

</html>
