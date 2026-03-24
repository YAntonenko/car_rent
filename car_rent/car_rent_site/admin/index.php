<?php
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$pageTitle = 'Autod admin';
$cars = get_admin_cars();
require_once __DIR__ . '/../inc/header.php';
?>

<section class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Autod</h1>
            <p class="text-secondary mb-0">Halda autorendi autode nimekirja.</p>
        </div>
        <a href="add_car.php" class="btn btn-dark btn-sm">Lisa auto</a>
    </div>

    <?php if ($msg = flash('success')): ?>
        <div class="alert alert-success"><?= e($msg) ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 90px;">Pilt</th>
                            <th>Auto</th>
                            <th>Mootor</th>
                            <th>Kütus</th>
                            <th>Hind</th>
                            <th>Kirjeldus</th>
                            <th class="text-end" style="width: 180px;">Tegevused</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td>
                                <img src="<?= e($car['image']) ?>"
                                     alt="<?= e($car['brand'] . ' ' . $car['model']) ?>"
                                     style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                            </td>
                            <td>
                                <div class="fw-semibold"><?= e($car['brand'] . ' ' . $car['model']) ?></div>
                                <div class="small text-secondary"><?= (int)$car['year'] ?></div>
                            </td>
                            <td><?= e($car['engine']) ?></td>
                            <td><?= e($car['fuel_type']) ?></td>
                            <td><?= number_format((float)$car['price_per_day'], 0) ?> € / päev</td>
                            <td style="max-width: 280px;">
                                <div class="small text-secondary">
                                    <?= e(mb_strimwidth($car['description'] ?? '', 0, 120, '...')) ?>
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="edit_car.php?id=<?= (int)$car['id'] ?>" class="btn btn-sm btn-outline-primary">Muuda</a>
                                <a href="delete_car.php?id=<?= (int)$car['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Kas kustutada see auto?');">
                                   Kustuta
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($cars)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-secondary">Autosid ei leitud.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-end mt-3">
        <a href="add_car.php" class="btn btn-dark btn-sm">Lisa auto</a>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
