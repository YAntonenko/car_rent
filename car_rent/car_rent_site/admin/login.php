<?php
require_once __DIR__ . '/../inc/functions.php';
if (is_admin_logged_in()) { redirect('index.php'); }
$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = db()->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin' LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_email'] = $user['email'];
        redirect('index.php');
    }
    $error = 'Vale e-post või parool.';
}
$pageTitle = 'Admin login';
require_once __DIR__ . '/../inc/header.php';
?>
<section class="container py-5" style="max-width: 520px;">
  <div class="bg-white rounded-4 shadow-sm p-4">
    <h1 class="h3 mb-4">Admin sisselogimine</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="row g-3">
      <div class="col-12"><label class="form-label">E-post</label><input type="email" name="email" class="form-control" required></div>
      <div class="col-12"><label class="form-label">Parool</label><input type="password" name="password" class="form-control" required></div>
      <div class="col-12 d-grid"><button class="btn btn-dark">Logi sisse</button></div>
      <div class="col-12 small text-secondary">Demo kasutaja: admin@example.com / admin123</div>
    </form>
  </div>
</section>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
