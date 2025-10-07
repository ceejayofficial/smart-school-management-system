
<div class="table-responsive">
  <table class="table table-bordered table-hover bg-white mb-0 text-nowrap">
    <thead class="table-light">
      <tr class="text-center">
        <th>#</th>
        <th>User Code</th>
        <th>Username</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Role</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $sn = $offset + 1; while ($row = $result->fetch_assoc()): ?>
        <tr class="align-middle text-left">
          <td><?= $sn++ ?></td>
          <td><?= htmlspecialchars($row['unique_code']) ?></td>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['role']) ?></td>
          <td><?= htmlspecialchars($row['created_at']) ?></td>
          <td>
            <div class="d-flex justify-content-left flex-wrap gap-1">
              <?php if ($row['id'] != $_SESSION['user_id']): ?>
                <button class="btn btn-sm btn-success edit-btn" data-user='<?= htmlspecialchars(json_encode($row), ENT_QUOTES) ?>'>Edit</button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
              <?php else: ?>
                <span class="text-muted small">You</span>
                
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Pagination -->
<nav class="mt-4">
  <ul class="pagination justify-content-center flex-wrap">
    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="btn btn-sm btn-dark me-2" href="?page=users&pg=<?= $page - 1 ?>">Previous</a>
      </li>
    <?php endif; ?>

    <?php for ($p = 1; $p <= $total_pages; $p++): ?>
      <li class="page-item">
        <a class="btn btn-sm <?= $p == $page ? 'btn-dark' : 'btn-outline-dark' ?> me-1" href="?page=users&pg=<?= $p ?>">
          <?= $p ?>
        </a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
      <li class="page-item">
        <a class="btn btn-sm btn-dark ms-2" href="?page=users&pg=<?= $page + 1 ?>">Next</a>
      </li>
    <?php endif; ?>
  </ul>
</nav>

