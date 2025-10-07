<?php
// Basic setup
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
  die("All fields are required.");
}

// Email
$to = 'ceejaytech@gmail.com';
$subject = "New Contact Message from $name";
$body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
$headers = "From: $email";

mail($to, $subject, $body, $headers);

// SMS via Mnotify or similar service
$smsMessage = "Contact Message from $name: $message";
$smsPayload = json_encode([
  'recipient' => ['233550190460'],
  'sender' => 'CeejayTech',
  'message' => $smsMessage,
  'is_schedule' => false
]);

$smsUrl = "https://app.mnotify.com/api/sms/quick"; // adjust if different
$smsContext = stream_context_create([
  'http' => [
    'method' => 'POST',
    'header' => "Content-Type: application/json\r\n",
    'content' => $smsPayload
  ]
]);

@file_get_contents($smsUrl, false, $smsContext);

// Redirect or confirm
echo "<script>alert('Message sent successfully!'); window.history.back();</script>";
