<?php
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$total_stmt = $conn->query("SELECT COUNT(*) as total FROM users");
$total_users = $total_stmt->fetch_assoc()['total'];
$total_pages = ceil($total_users / $limit);

$stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

// Generate unique user code
$last = $conn->query("SELECT unique_code FROM users ORDER BY id DESC LIMIT 1");
$num = ($last->num_rows > 0) ? intval(substr($last->fetch_assoc()['unique_code'], 3)) + 1 : 1;
$new_code = "USR" . str_pad($num, 5, '0', STR_PAD_LEFT);
?>
