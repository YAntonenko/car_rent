<?php
require_once __DIR__ . '/inc/functions.php';
$title = 'Autod';
$q = trim($_GET['q'] ?? '');
$cars = get_cars($q);
require_once __DIR__ . '/inc/header.php';
?>
<main class="container py-4">
    <h1>Autod</h1>
    <?php if ($q): ?><p>Otsing: <b><?= e($q) ?></b></p><?php endif; ?>
    <div class="row g-4">
        <?php foreach ($cars as $car): ?>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm">
                    <img src="<?= e(car_image($car['image'] ?? '')) ?>" class="card-img-top car-img" alt="<?= e($car['mark'].' '.$car['model']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= e($car['mark']) ?> <?= e($car['model']) ?></h5>
                        <p class="card-text small text-secondary">
                            <?= e($car['engine'] ?? '') ?>, <?= e($car['fuel'] ?? '') ?><br>
                            <?= (int)($car['year'] ?? 0) ?>
                        </p>
                        <p class="fw-bold"><?= number_format((float)($car['price'] ?? 0), 0) ?> € / päev</p>
                        <a href="auto.php?id=<?= (int)$car['id'] ?>" class="btn btn-dark btn-sm">Rendi</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (!$cars): ?><p>Autosid ei leitud.</p><?php endif; ?>
    </div>
</main>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
