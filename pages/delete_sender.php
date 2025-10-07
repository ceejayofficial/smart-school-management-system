<?php
require_once __DIR__ . '/../db.php';

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $conn->prepare("DELETE FROM sender_id WHERE id = ?");
  $stmt->bind_param("i", $id);
  
  if ($stmt->execute()) {
    echo "success";
  } else {
    echo "Failed to delete";
  }

  $stmt->close();
}
?>
