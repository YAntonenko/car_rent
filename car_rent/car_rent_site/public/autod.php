<?php
$pageTitle = 'Autod';
require_once __DIR__ . '/../inc/header.php';
$q = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;
$totalCars = count_cars($q);
$totalPages = max(1, (int)ceil($totalCars / $perPage));
$cars = get_cars($q, $perPage, $offset);
?>
<section class="container py-5">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="h2 mb-1">Autode valik</h1>
      <p class="text-secondary mb-0"><?= $q !== '' ? 'Otsing: ' . e($q) : 'Sirvi kõiki saadaolevaid autosid.' ?></p>
    </div>
    <form class="d-flex" method="get">
      <input class="form-control me-2" type="search" name="q" placeholder="BMW, Audi, Corolla..." value="<?= e($q) ?>">
      <button class="btn btn-dark" type="submit">Otsi</button>
    </form>
  </div>

  <div class="row g-4">
    <?php if (!$cars): ?>
      <div class="col-12"><div class="alert alert-warning">Sobivaid autosid ei leitud.</div></div>
    <?php endif; ?>

    <?php foreach ($cars as $car): ?>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card car-card h-100 shadow-sm border-0">
          <img src="<?= e($car['image']) ?>" class="card-img-top" alt="<?= e($car['brand'] . ' ' . $car['model']) ?>">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
              <h2 class="h5 mb-0"><?= e($car['brand'] . ' ' . $car['model']) ?></h2>
              <span class="badge text-bg-<?= status_badge_class($car['status']) ?>"><?= e($car['status']) ?></span>
            </div>
            <p class="text-secondary small mb-2"><?= e($car['year']) ?> • <?= e($car['engine']) ?> • <?= e($car['fuel_type']) ?></p>
            <p class="small mb-2">Kohti: <?= (int)$car['seats'] ?> • Käigukast: <?= e($car['transmission']) ?></p>
            <p class="fw-semibold mb-3">€<?= number_format((float)$car['price_per_day'], 2) ?>/päev</p>
            <a href="auto.php?id=<?= (int)$car['id'] ?>" class="btn btn-dark mt-auto">Rendi</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <nav class="mt-5">
    <ul class="pagination justify-content-center">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" href="?q=<?= urlencode($q) ?>&page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</section>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
