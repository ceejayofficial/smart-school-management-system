<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['username'])) {
    echo json_encode(["logged_in" => true]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>
