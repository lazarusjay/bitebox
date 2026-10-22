<?php
include 'includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];
    $action = $_POST['action'];

    if ($action === 'register') {
        $name = trim($_POST['name']);
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
            $stmt->execute([$name, $email, $hash]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            header('Location: index.php'); exit;
        } catch (PDOException $e) { $error = 'Email already registered.'; }
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if ($u && password_verify($pass, $u['password'])) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['user_name'] = $u['name'];
            header('Location: index.php'); exit;
        } else $error = 'Invalid credentials.';
    }
}
?>
<section class="container section">
    <h2 class="section-title">Login / Register</h2>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <div class="auth-wrap">
        <form method="post" class="auth-form">
            <h3>Login</h3>
            <input type="hidden" name="action" value="login">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="btn" type="submit">Login</button>
        </form>
        <form method="post" class="auth-form">
            <h3>Register</h3>
            <input type="hidden" name="action" value="register">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="btn" type="submit">Register</button>
        </form>
    </div>
</section>
<?php include 'includes/footer.php'; ?>