<?php
// Ensure reference is provided
$ref = $_GET['ref'] ?? '';

if (!$ref) {
    echo "<h3 class='text-danger text-center mt-5'>Invalid or missing reference number.</h3>";
    exit;
}

// Query to get result and uploader's username (as school name)
$stmt = $conn->prepare("
    SELECT sr.*, u.username 
    FROM sms_results sr
    JOIN users u ON sr.user_id = u.id
    WHERE sr.phone = ?
");
$stmt->bind_param("s", $ref);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="text-center px-3">
            <div class="spinner-border text-secondary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h4 class="mt-4 text-danger">No results found for this reference number.</h4>
            <p class="text-muted">Check your reference or contact the school.</p>
        </div>
    </div>';
    exit;
}

// Get school name from the user who uploaded the result
$tempRow = $result->fetch_assoc();
$school_name = htmlspecialchars($tempRow['username']);

// Reset result pointer so it can be looped again in main view
$result->data_seek(0);
