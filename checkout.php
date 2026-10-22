<?php
include 'includes/header.php';
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $i) $total += $i['price'] * $i['qty'];

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $cart) {
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, address, phone) VALUES (?,?,?,?)");
    $stmt->execute([$_SESSION['user_id'] ?? null, $total, $_POST['address'], $_POST['phone']]);
    $orderId = $pdo->lastInsertId();

    $stmt2 = $pdo->prepare("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?,?,?,?)");
    foreach ($cart as $id => $item) {
        $stmt2->execute([$orderId, $id, $item['qty'], $item['price']]);
    }
    unset($_SESSION['cart']);
    $success = true;
}
?>
<section class="container section">
    <h2 class="section-title">Checkout</h2>
    <?php if ($success): ?>
        <div class="success-box">
            <h3>✅ Order placed successfully!</h3>
            <p>Thank you for ordering from BiteBox. We'll deliver soon.</p>
            <a href="menu.php" class="btn">Order More</a>
        </div>
    <?php elseif (!$cart): ?>
        <p>Your cart is empty. <a href="menu.php">Browse menu →</a></p>
    <?php else: ?>
        <div class="checkout-wrap">
            <form method="post" class="checkout-form">
                <label>Delivery Address</label>
                <textarea name="address" required></textarea>
                <label>Phone Number</label>
                <input type="text" name="phone" required>
                <p class="total-line">Total: <strong>$<?= number_format($total,2) ?></strong></p>
                <button type="submit" class="btn">Place Order</button>
            </form>
        </div>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>