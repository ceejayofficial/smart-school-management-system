<?php
include("header.php");

// Check if the user is logged in by verifying the session user_id
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in first.";
    exit;
}

$userId = $_SESSION['user_id'];  // Now using user_id from session

// Pagination settings
$limit = 10;  // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Current page
$offset = ($page - 1) * $limit;  // Offset for SQL query

// Prepare the query for fetching data
$stmt = $conn->prepare("SELECT * FROM sms_history WHERE id = ? ORDER BY sent_at DESC LIMIT ?, ?");
$stmt->bind_param("iii", $userId, $offset, $limit); // "iii" means three integers
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of records for pagination
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM sms_history WHERE id = $userId");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

?>

<div class="container mt-5">
  <h3 class="text-2xl font-semibold mb-4">📜 SMS Send History</h3>
  
  <!-- Table to display SMS history -->
  <table class="table-auto w-full border-collapse border border-gray-300">
    <thead class="bg-green-200">
      <tr>
        <th class="px-4 py-2 border">#</th>
        <th class="px-4 py-2 border">To</th>
        <th class="px-4 py-2 border">Status</th>
        <th class="px-4 py-2 border">Sender ID</th>
        <th class="px-4 py-2 border">Message</th>
        <th class="px-4 py-2 border">Time</th>
        <th class="px-4 py-2 border">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row['id']) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row['contact']) ?></td>
          <td class="px-4 py-2 border <?= $row['status'] === 'success' ? 'text-green-600' : 'text-red-600' ?>"><?= htmlspecialchars($row['status']) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row['sender_id']) ?></td>
          <td class="px-4 py-2 border"><?= htmlspecialchars(substr($row['message'], 0, 30)) ?>...</td>
          <td class="px-4 py-2 border"><?= htmlspecialchars($row['sent_at']) ?></td>
          <td class="px-4 py-2 border">
            <?php if ($row['status'] === 'failed'): ?>
              <button class="btn btn-outline-danger btn-sm" onclick="showDetail(`<?= addslashes($row['error_detail']) ?>`)">View</button>
              <form method="POST" action="delete_sms.php" style="display:inline;">
                <input type="hidden" name="sms_id" value="<?= $row['id'] ?>" />
                <button type="submit" class="btn btn-outline-warning btn-sm">Delete</button>
              </form>
            <?php else: ?>
              <span class="text-muted">-</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- Pagination Controls -->
  <nav class="mt-4">
    <ul class="pagination justify-content-center">
      <!-- Previous Page Link -->
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- Page Numbers -->
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <!-- Next Page Link -->
      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</div>

<!-- JavaScript for displaying error details in a popup -->
<script>
  function showDetail(detail) {
    Swal.fire({
      title: 'Error Detail',
      text: detail,
      icon: 'error'
    });
  }
</script>

<?php
$stmt->close();
include("footer.php");
?>
