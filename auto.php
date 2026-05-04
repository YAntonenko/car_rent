<?php
require_once __DIR__ . '/inc/functions.php';
$id = (int)($_GET['id'] ?? 0);
$car = get_car($id);
if (!$car) die('Autot ei leitud.');
$title = $car['mark'] . ' ' . $car['model'];
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    if ($name && $email && $start && $end && $end >= $start) {
        $days = max(1, (strtotime($end) - strtotime($start)) / 86400 + 1);
        $total = $days * (float)$car['price'];
        $stmt = db()->prepare("INSERT INTO reservations (car_id, name, email, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, ?, 'active')");
        $stmt->bind_param('issssd', $id, $name, $email, $start, $end, $total);
        $stmt->execute();
        $msg = 'Broneering salvestatud. Hind kokku: ' . number_format($total, 0) . ' €';
    } else {
        $msg = 'Palun täida kõik väljad.';
    }
}
require_once __DIR__ . '/inc/header.php';
?>
<main class="container py-4">
    <div class="row g-4">
        <div class="col-md-6"><img class="img-fluid rounded shadow-sm" src="<?= e(car_image($car['image'] ?? '')) ?>" alt="Auto"></div>
        <div class="col-md-6">
            <h1><?= e($car['mark']) ?> <?= e($car['model']) ?></h1>
            <p>Mootor: <?= e($car['engine'] ?? '') ?></p>
            <p>Kütus: <?= e($car['fuel'] ?? '') ?></p>
            <p>Aasta: <?= (int)($car['year'] ?? 0) ?></p>
            <p class="h4"><?= number_format((float)$car['price'], 0) ?> € / päev</p>
            <p><?= e($car['description'] ?? '') ?></p>
        </div>
    </div>
    <section class="card mt-4 shadow-sm"><div class="card-body">
        <h2 class="h4">Broneeri auto</h2>
        <?php if ($msg): ?><div class="alert alert-info"><?= e($msg) ?></div><?php endif; ?>
        <form method="post" class="row g-3">
            <div class="col-md-6"><label class="form-label">Nimi</label><input class="form-control" name="name"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input class="form-control" name="email" type="email"></div>
            <div class="col-md-6"><label class="form-label">Algus</label><input class="form-control" name="start_date" type="date"></div>
            <div class="col-md-6"><label class="form-label">Lõpp</label><input class="form-control" name="end_date" type="date"></div>
            <div><button class="btn btn-dark">Saada broneering</button></div>
        </form>
    </div></section>
</main>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
