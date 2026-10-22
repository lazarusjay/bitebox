<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP is working!<br>";

require_once 'config/db.php';
echo "DB connected!<br>";

$count = $pdo->query("SELECT COUNT(*) FROM foods")->fetchColumn();
echo "Foods in DB: $count";
?>