<?php
require_once "../../db.php";
require_once "../includes/auth.php";

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['teacher_id']) || empty($_POST['teacher_id'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid ID',
                text: 'Teacher ID is missing.'
            }).then(() => {
                window.history.back();
            });
        </script>";
        exit;
    }

    $id = $_POST['teacher_id'];

    $stmt = $conn->prepare("DELETE FROM teachers WHERE teacher_id=?");
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Teacher has been removed successfully.'
            }).then(() => {
                window.location.href = '../dashboard/admin_dashboard.php?page=teachers_records';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Could not delete teacher. Please try again.'
            }).then(() => {
                window.location.href = '../dashboard/admin_dashboard.php?page=teachers_records';
            });
        </script>";
    }
}
?>
