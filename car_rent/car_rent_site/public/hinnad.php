<?php
$pageTitle = 'Hinnad';
require_once __DIR__ . '/../inc/header.php';
$cars = get_cars('', 100, 0);
?>
<section class="container py-5">
  <h1 class="h2 mb-4">Hinnakiri</h1>
  <div class="table-responsive bg-white rounded-4 shadow-sm p-3">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>Auto</th><th>Aasta</th><th>Kütus</th><th>Käigukast</th><th>Hind / päev</th></tr></thead>
      <tbody>
        <?php foreach ($cars as $car): ?>
        <tr>
          <td><a class="text-decoration-none" href="auto.php?id=<?= (int)$car['id'] ?>"><?= e($car['brand'] . ' ' . $car['model']) ?></a></td>
          <td><?= e($car['year']) ?></td>
          <td><?= e($car['fuel_type']) ?></td>
          <td><?= e($car['transmission']) ?></td>
          <td>€<?= number_format((float)$car['price_per_day'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
