<?php
require_once 'config/db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $stmt = $pdo->prepare("SELECT id, name, price FROM foods WHERE id=?");
        $stmt->execute([$id]);
        if ($food = $stmt->fetch()) {
            $_SESSION['cart'][$id] = [
                'name'  => $food['name'],
                'price' => $food['price'],
                'qty'   => 1
            ];
        }
    }
}
header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'menu.php'));
exit;