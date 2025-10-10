<?php
require_once "../db.php";

// Include SweetAlert
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $level = trim($_POST['level']);
    $class_name = trim($_POST['class_name']);
    $new_class = trim($_POST['new_class']);

    // Use new class if entered, otherwise selected one
    $final_class = !empty($new_class) ? $new_class : $class_name;

    if (!empty($level) && !empty($final_class)) {
        $stmt = $conn->prepare("INSERT INTO classes (level, class_name) VALUES (?, ?)");
        
        if (!$stmt) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Database error: " . $conn->error . "',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../dashboard/admin_dashboard.php?page=create_class';
                    });
                  </script>";
            exit;
        }

        $stmt->bind_param("ss", $level, $final_class);

        if ($stmt->execute()) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Class created successfully.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../dashboard/admin_dashboard.php?page=create_class';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to create class.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '../dashboard/admin_dashboard.php?page=create_class';
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing fields!',
                    text: 'Please select level and class name.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '../dashboard/admin_dashboard.php?page=create_class';
                });
              </script>";
    }
}
?>
