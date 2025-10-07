<?php
require_once '../db.php';

$found_user = null;
$sms_history = [];
$highest_limit = null;
$total_sms_used = null;

if (isset($_GET['user_id']) && isset($_GET['page']) && $_GET['page'] === 'load') {
    $unique_code = trim($_GET['user_id']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE unique_code = ?");
    $stmt->bind_param("s", $unique_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $found_user = $result->fetch_assoc();

    if ($found_user) {
        $user_id = $found_user['id'];

        $stmt2 = $conn->prepare("SELECT * FROM sms_history WHERE user_id = ? ORDER BY sms_limit DESC, sent_at DESC LIMIT 3");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $sms_history = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt3 = $conn->prepare("SELECT sms_limit, sms_used FROM sms_history WHERE user_id = ? ORDER BY sms_limit DESC, sent_at DESC LIMIT 1");
        $stmt3->bind_param("i", $user_id);
        $stmt3->execute();
        $row3 = $stmt3->get_result()->fetch_assoc();

        $highest_limit = $row3['sms_limit'] ?? 0;
        $total_sms_used = $row3['sms_used'] ?? 0;
    }
}
?>
