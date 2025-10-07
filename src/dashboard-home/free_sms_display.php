<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../db.php'; 

$user_id = $_SESSION['user_id'] ?? null;
$sms_left = 0;
$is_free_credit = false;

if ($user_id && $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS record_count FROM sms_history WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $record_count = $row['record_count'] ?? 0;

    if ($record_count == 0) {
        $sms_left = 1;
        $is_free_credit = true;
    } else {
        // Optional: fetch actual remaining SMS if needed from another table or logic
        $stmt2 = $conn->prepare("SELECT SUM(sms_used) AS total_used, MAX(sms_limit) AS max_limit FROM sms_history WHERE user_id = ?");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $res2 = $stmt2->get_result()->fetch_assoc();

        $total_used = (int)($res2['total_used'] ?? 0);
        $max_limit = (int)($res2['max_limit'] ?? 0);
        $sms_left = max($max_limit - $total_used, 0);
        $is_free_credit = false;
    }
}
?>