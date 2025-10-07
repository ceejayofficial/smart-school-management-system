<?php
require_once '../db.php';

$swal_message = '';
$swal_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_limit'])) {
    $user_id = $_POST['user_id'];
    $new_limit = $_POST['new_limit'];

    if (is_numeric($new_limit)) {
        $stmt = $conn->prepare("
            UPDATE sms_history 
            SET sms_limit = ? 
            WHERE id = (
                SELECT id FROM (
                    SELECT id FROM sms_history 
                    WHERE user_id = ? 
                    ORDER BY sent_at DESC, id DESC 
                    LIMIT 1
                ) AS last_row
            )
        ");
        $stmt->bind_param("ii", $new_limit, $user_id);

        if ($stmt->execute()) {
            $swal_type = 'success';
            $swal_message = 'Wallet Loaded !';
        } else {
            $swal_type = 'error';
            $swal_message = 'Failed to Load Wallet.';
        }
    } else {
        $swal_type = 'error';
        $swal_message = ' Enter a valid number.';
    }
}
?>
