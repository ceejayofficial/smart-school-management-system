<?php

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
  $_SESSION['access_denied'] = "Admins are not allowed to access this page.";
  header("Location: admin/index.php");
  exit();
}

if (!isset($_SESSION['user_id'])) {
  session_destroy();
  exit();
}

if (isset($_GET['terms_declined']) || isset($_SESSION['declined_terms'])) {
  session_destroy();
  exit();
}

if (!isset($_SESSION['accepted_terms']) || $_SESSION['accepted_terms'] !== true) {
  header("Location: terms.php");
  exit();
}



$page = $_GET['page'] ?? 'dashboard-home';
$contentFile = "pages/" . $page . ".php";

echo '<main class="main-content">';
if (file_exists($contentFile)) {
  include($contentFile);
} else {
  include('404.php');
}
echo '</main>';
