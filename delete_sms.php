<?php

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in. Please log in first.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sms_id'])) {
    $smsId = $_POST['sms_id'];

    $stmt = $conn->prepare("DELETE FROM sms_history WHERE id = ? AND id = ?");
    $stmt->bind_param("ii", $_SESSION['user_id'], $smsId);  // Check if the SMS belongs to the logged-in user
    $stmt->execute();

    header("Location: sms_history.php");
    exit;
}

?>
