<?php


$page = $_GET['page'] ?? 'dashboard-home';
$contentFile = "page/" . $page . ".php";

echo '<main class="main-content">';
if (file_exists($contentFile)) {
    include($contentFile);
} else {
    include('404.php');
}
echo '</main>';
?>
