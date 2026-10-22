<?php include 'includes/header.php'; ?>
<section class="hero">
    <div class="container">
        <h1>Delicious Food, <span>Delivered Fast</span></h1>
        <p>Order from BiteBox and get your favorites in 30 minutes or less.</p>
        <a href="menu.php" class="btn">Browse Menu</a>
    </div>
</section>

<section class="container section">
    <h2 class="section-title">Popular Picks</h2>
    <div class="grid">
        <?php
        $foods = $pdo->query("SELECT * FROM foods LIMIT 4")->fetchAll();
        foreach ($foods as $f): ?>
        <div class="card">
            <div class="card-img" style="background-image:url('<?= food_image($f['image'], $f['name']) ?>');background-size:cover;background-position:center;"></div>
            <h3><?= htmlspecialchars($f['name']) ?></h3>
            <p><?= htmlspecialchars($f['description']) ?></p>
            <div class="card-footer">
                <span class="price">$<?= number_format($f['price'], 2) ?></span>
                <a href="add_to_cart.php?id=<?= $f['id'] ?>" class="btn-sm">Add</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'includes/footer.php'; ?>