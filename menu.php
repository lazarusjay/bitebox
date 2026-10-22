<?php
include 'includes/header.php';
$cat = $_GET['cat'] ?? '';
$sql = "SELECT * FROM foods";
if ($cat) $sql .= " WHERE category = :cat";
$stmt = $pdo->prepare($sql);
$stmt->execute($cat ? [':cat' => $cat] : []);
$foods = $stmt->fetchAll();
$cats = $pdo->query("SELECT DISTINCT category FROM foods")->fetchAll(PDO::FETCH_COLUMN);
?>
<section class="container section">
    <h2 class="section-title">Our Menu</h2>
    <div class="filters">
        <a href="menu.php" class="<?= !$cat ? 'active' : '' ?>">All</a>
        <?php foreach ($cats as $c): ?>
            <a href="menu.php?cat=<?= urlencode($c) ?>" class="<?= $cat==$c ? 'active' : '' ?>">
                <?= htmlspecialchars($c) ?>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="grid">
        <?php foreach ($foods as $f): ?>
        <div class="card">
            <div class="card-img"><i class="fa-solid fa-utensils"></i></div>
            <h3><?= htmlspecialchars($f['name']) ?></h3>
            <p><?= htmlspecialchars($f['description']) ?></p>
            <div class="card-footer">
                <span class="price">$<?= number_format($f['price'], 2) ?></span>
                <a href="add_to_cart.php?id=<?= $f['id'] ?>" class="btn-sm">Add to Cart</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>