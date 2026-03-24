<?php
$pageTitle = 'Avaleht';
require_once __DIR__ . '/../inc/header.php';
$cars = get_cars('', 4, 0);
?>
<section class="container py-5">
  <div class="row align-items-center g-4 hero-card rounded-4 shadow-sm p-4 p-lg-5">
    <div class="col-lg-6">
      <span class="badge text-bg-dark mb-3">Usaldusväärne autorent</span>
      <h1 class="display-5 fw-bold mb-3">Leia endale sobiv rendiauto mõne minutiga</h1>
      <p class="lead text-secondary">Lihtne valik, läbipaistev hind ja kiire broneerimine. Sirvi valikut, vaata detaili ja broneeri sobivaks perioodiks.</p>
      <div class="d-flex gap-2">
        <a href="autod.php" class="btn btn-dark btn-lg">Vaata autosid</a>
        <a href="kontakt.php" class="btn btn-outline-dark btn-lg">Küsi pakkumist</a>
      </div>
    </div>
    <div class="col-lg-6">
      <img class="img-fluid rounded-4 hero-image w-100 shadow-sm" src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80" alt="Hero auto">
    </div>
  </div>
</section>
<section class="container pb-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="h3 mb-1">Populaarsed autod</h2>
      <p class="text-secondary mb-0">Näidisandmed andmebaasist.</p>
    </div>
    <a href="autod.php" class="btn btn-outline-dark">Kõik autod</a>
  </div>
  <div class="row g-4">
    <?php foreach ($cars as $car): ?>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="card car-card h-100 shadow-sm border-0">
          <img src="<?= e($car['image']) ?>" class="card-img-top" alt="<?= e($car['brand'] . ' ' . $car['model']) ?>">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2 gap-2">
              <h3 class="h5 mb-0"><?= e($car['brand'] . ' ' . $car['model']) ?></h3>
              <span class="badge text-bg-<?= status_badge_class($car['status']) ?>"><?= e($car['status']) ?></span>
            </div>
            <p class="text-secondary small mb-2"><?= e($car['year']) ?> • <?= e($car['fuel_type']) ?> • <?= e($car['transmission']) ?></p>
            <p class="fw-semibold mb-3">€<?= number_format((float)$car['price_per_day'], 2) ?>/päev</p>
            <a href="auto.php?id=<?= (int)$car['id'] ?>" class="btn btn-dark w-100">Rendi</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
