<?php
include './header.php';
include './includes/sender-logic.php';
?>

<div class="container mt-5">
    <h2>Manage Senders</h2>

    <form method="GET" action="dashboard.php" class="mb-4">
        <input type="hidden" name="page" value="senders">
        <div class="input-group">
            <input type="text" name="user_id" class="form-control" placeholder="Enter User Code" value="<?= htmlspecialchars($_GET['user_id'] ?? '') ?>">
            <button class="btn btn-dark">Search</button>
        </div>
    </form>

    <?php if ($user_found): ?>
        <div class="alert alert-success mb-3">
            search result: <strong><?= htmlspecialchars($user_name) ?></strong>
        </div>
        <?php include './includes/sender-form.php'; ?>
    <?php elseif (isset($_GET['user_id'])): ?>
        <div class="alert alert-danger">User not found</div>
    <?php endif; ?>

    <?php include './includes/sender-list.php'; ?>
</div>
