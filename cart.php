<?php
include 'includes/header.php';
$cart = $_SESSION['cart'] ?? [];

// Handle remove / update
if (isset($_GET['remove'])) {
    unset($_SESSION['cart'][(int)$_GET['remove']]);
    header('Location: cart.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $id => $q) {
        $q = (int)$q;
        if ($q <= 0) unset($_SESSION['cart'][$id]);
        else $_SESSION['cart'][$id]['qty'] = $q;
    }
    header('Location: cart.php'); exit;
}
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) $total += $item['price'] * $item['qty'];
?>
<section class="container section">
    <h2 class="section-title">Your Cart</h2>
    <?php if (!$cart): ?>
        <p>Your cart is empty. <a href="menu.php">Browse menu →</a></p>
    <?php else: ?>
    <form method="post">
    <table class="cart-table">
        <tr><th>Item</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr>
        <?php foreach ($cart as $id => $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td>$<?= number_format($item['price'], 2) ?></td>
            <td><input type="number" name="qty[<?= $id ?>]" value="<?= $item['qty'] ?>" min="0"></td>
            <td>$<?= number_format($item['price'] * $item['qty'], 2) ?></td>
            <td><a href="cart.php?remove=<?= $id ?>" class="remove">✕</a></td>
        </tr>
        <?php endforeach; ?>
        <tr class="total-row">
            <td colspan="3" align="right"><strong>Total:</strong></td>
            <td colspan="2"><strong>$<?= number_format($total, 2) ?></strong></td>
        </tr>
    </table>
    <div class="cart-actions">
        <button type="submit" class="btn-sm">Update Cart</button>
        <a href="checkout.php" class="btn">Checkout</a>
    </div>
    </form>
    <?php endif; ?>
</section>
<?php include 'includes/footer.php'; ?>