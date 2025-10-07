<?php
require_once '../../db.php';
header('Content-Type: application/json');

try {
    // Trim and sanitize all inputs
    $code = htmlspecialchars(trim($_POST['unique_code'] ?? ''));
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $password_raw = $_POST['password'] ?? '';
    $role = htmlspecialchars(trim($_POST['role'] ?? ''));

    // 1. Required fields
    if (empty($code) || empty($username) || empty($email) || empty($password_raw) || empty($role)) {
        throw new Exception("Please fill all required fields.");
    }


    $username = htmlspecialchars(trim($_POST['username'] ?? ''));

    // 3.1 Validate username: no spaces, max 10 characters
    if (strlen($username) > 10) {
        throw new Exception("Username must not exceed 10 characters.");
    }
    if (preg_match('/\s/', $username)) {
        throw new Exception("Username must not contain spaces.");
    }
    
    // 2. Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format.");
    }

    // 3. Detect disposable/fake emails (basic domain block)
    $disposable_domains = ['mailinator.com', '10minutemail.com', 'guerrillamail.com', 'yopmail.com'];
    $domain = substr(strrchr($email, "@"), 1);
    if (in_array(strtolower($domain), $disposable_domains)) {
        throw new Exception("Disposable email addresses are not allowed.");
    }

    // 4. Validate password strength
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,\-])[A-Za-z\d@$!%*?&.,\-]{8,}$/', $password_raw)) {
        throw new Exception("Password must be at least 8 characters, include uppercase, lowercase, number, and special character.");
    }

    // 5. Validate phone (optional)
    if (!empty($phone) && !preg_match('/^\+?[0-9]{8,15}$/', $phone)) {
        throw new Exception("Invalid phone number format.");
    }

    // 6. Validate password strength
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,\-])[A-Za-z\d@$!%*?&.,\-]{8,}$/', $password_raw)) {
        throw new Exception("Password must be at least 8 characters, include uppercase, lowercase, number, and special character.");
    }

    // 4.1 Check against common passwords
    $common_passwords = [
        'Pa$$w0rd!',
        'Welcome@123',
        'Admin@123',
        'Qwerty@123',
        'Test@1234',
        'Passw0rd!',
        'Password@123',
        'User@1234',
        'Root@1234',
        'Changeme@1',
        'Letmein@123',
        'IloveYou@1',
        'Default@123',
        'Abcd@1234',
        'Login@1234',
        'MyPass@123',
        'SuperUser@1',
        'Secure@123',
        'System@123',
        'P@ssword1'
    ];

    if (in_array(strtolower($password_raw), array_map('strtolower', $common_passwords))) {
        throw new Exception("This password is too common");
    }

    // 6. Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) {
        throw new Exception("Email already exists.");
    }

    // 7. Hash password
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // 8. Insert user
    $stmt = $conn->prepare("INSERT INTO users (unique_code, username, email, phone, password, role, created_at)
                            VALUES (?, ?, ?, ?, ?, ?, NOW())");
    if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);

    $stmt->bind_param("ssssss", $code, $username, $email, $phone, $password, $role);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode(['success' => true, 'message' => 'User registered successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
