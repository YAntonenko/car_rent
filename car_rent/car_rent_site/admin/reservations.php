<?php
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$pageTitle = 'Reserveeringud';
$reservations = get_admin_reservations();
require_once __DIR__ . '/../inc/header.php';
?>

<section class="container py-4">
    <div class="mb-3">
        <h1 class="h3 mb-1">Reserveeringud</h1>
        <p class="text-secondary mb-0">Kõik aktiivsed ja varasemad broneeringud.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Klient</th>
                            <th>Auto</th>
                            <th>Periood</th>
                            <th>Summa</th>
                            <th>Staatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?= (int)$reservation['id'] ?></td>
                            <td>
                                <div class="fw-semibold"><?= e($reservation['first_name'] . ' ' . $reservation['last_name']) ?></div>
                                <div class="small text-secondary"><?= e($reservation['email']) ?></div>
                            </td>
                            <td><?= e($reservation['brand'] . ' ' . $reservation['model']) ?></td>
                            <td><?= e($reservation['start_date']) ?> – <?= e($reservation['end_date']) ?></td>
                            <td><?= number_format((float)$reservation['total_price'], 2) ?> €</td>
                            <td><span class="badge text-bg-<?= status_badge_class($reservation['status']) ?>"><?= e($reservation['status']) ?></span></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($reservations)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-secondary">Reserveeringuid ei leitud.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
