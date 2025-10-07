<?php
require_once '../db.php';

$user_found = false;
$user_name = '';
$user_id = null;
$search_key = $_GET['user_id'] ?? ''; // can be id or unique_code

// Try to find user by id or unique_code
if ($search_key !== '') {
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE id = ? OR unique_code = ?");
    $stmt->bind_param("is", $search_key, $search_key); // support both integer & string
    $stmt->execute();
    $stmt->bind_result($user_id, $user_name);
    if ($stmt->fetch()) {
        $user_found = true;
    }
    $stmt->close();
}

// Handle Add Sender
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sender_name'], $_POST['user_id'])) {
    $sender_name = trim($_POST['sender_name']);
    $user_id_post = intval($_POST['user_id']);
    if ($sender_name !== '') {
        $stmt = $conn->prepare("INSERT INTO sender_id (user_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id_post, $sender_name);
        if ($stmt->execute()) {
            $_SESSION['swal_success'] = "Sender added successfully!";
        } else {
            $_SESSION['swal_error'] = "Failed to add sender.";
        }
    } else {
        $_SESSION['swal_error'] = "Sender name cannot be empty.";
    }
    header("Location: senders.php?user_id=$user_id_post");
    exit;
}

// Handle Delete Sender
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM sender_id WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $_SESSION['swal_success'] = "Sender deleted successfully.";
    header("Location: senders.php?user_id=" . urlencode($search_key));
    exit;
}

// Fetch Senders
$senders = [];
if ($user_found && $user_id) {
    $stmt = $conn->prepare("SELECT * FROM sender_id WHERE user_id = ? ORDER BY id DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $senders[] = $row;
    }
    $stmt->close();
}
?>
