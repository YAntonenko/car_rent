<?php
require_once __DIR__ . '/../inc/functions.php';
$id = (int)($_GET['id'] ?? 0);
$car = get_car($id);
if (!$car) {
    http_response_code(404);
    echo 'Auto ei leitud';
    exit;
}

$pageTitle = $car['brand'] . ' ' . $car['model'];
$errors = [];
$success = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    if ($firstName === '' || $lastName === '' || $email === '' || $startDate === '' || $endDate === '') {
        $errors[] = 'Palun täida kõik kohustuslikud väljad.';
    }
    if ($startDate !== '' && $endDate !== '' && $startDate > $endDate) {
        $errors[] = 'Alguskuupäev ei tohi olla pärast lõppkuupäeva.';
    }
    if ($startDate !== '' && $endDate !== '' && reservation_overlaps($id, $startDate, $endDate)) {
        $errors[] = 'Sellel perioodil on auto juba broneeritud.';
    }

    if (!$errors) {
        $userId = get_or_create_user($firstName, $lastName, $email, $phone);
        $totalPrice = calculate_total_price($startDate, $endDate, (float)$car['price_per_day']);
        if (create_reservation($userId, $id, $startDate, $endDate, $totalPrice)) {
            $success = 'Broneering salvestati. Koguhind: €' . number_format($totalPrice, 2);
        } else {
            $errors[] = 'Broneeringu salvestamine ebaõnnestus.';
        }
    }
}
require_once __DIR__ . '/../inc/header.php';
?>
<section class="container py-5">
  <div class="row g-4">
    <div class="col-lg-7"><img src="<?= e($car['image']) ?>" class="img-fluid rounded-4 shadow-sm w-100" alt="<?= e($car['brand'] . ' ' . $car['model']) ?>"></div>
    <div class="col-lg-5">
      <div class="bg-white rounded-4 shadow-sm p-4 h-100">
        <div class="d-flex justify-content-between align-items-start mb-3 gap-3">
          <div>
            <h1 class="h2 mb-1"><?= e($car['brand'] . ' ' . $car['model']) ?></h1>
            <p class="text-secondary mb-0"><?= e($car['year']) ?> • <?= e($car['registration_number']) ?></p>
          </div>
          <span class="badge text-bg-<?= status_badge_class($car['status']) ?>"><?= e($car['status']) ?></span>
        </div>
        <div class="row g-3 small mb-4">
          <div class="col-6"><strong>Mootor:</strong><br><?= e($car['engine']) ?></div>
          <div class="col-6"><strong>Kütus:</strong><br><?= e($car['fuel_type']) ?></div>
          <div class="col-6"><strong>Käigukast:</strong><br><?= e($car['transmission']) ?></div>
          <div class="col-6"><strong>Kohad:</strong><br><?= (int)$car['seats'] ?></div>
        </div>
        <p><?= nl2br(e($car['description'])) ?></p>
        <p class="fs-4 fw-bold mb-0">€<?= number_format((float)$car['price_per_day'], 2) ?> / päev</p>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-lg-8">
      <div class="bg-white rounded-4 shadow-sm p-4">
        <h2 class="h4 mb-3">Broneeri auto</h2>
        <?php foreach ($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
        <?php if ($success): ?><div class="alert alert-success"><?= e($success) ?></div><?php endif; ?>
        <form method="post" class="row g-3">
          <div class="col-md-6"><label class="form-label">Eesnimi</label><input type="text" name="first_name" class="form-control" required value="<?= e($_POST['first_name'] ?? '') ?>"></div>
          <div class="col-md-6"><label class="form-label">Perenimi</label><input type="text" name="last_name" class="form-control" required value="<?= e($_POST['last_name'] ?? '') ?>"></div>
          <div class="col-md-6"><label class="form-label">E-post</label><input type="email" name="email" class="form-control" required value="<?= e($_POST['email'] ?? '') ?>"></div>
          <div class="col-md-6"><label class="form-label">Telefon</label><input type="text" name="phone" class="form-control" value="<?= e($_POST['phone'] ?? '') ?>"></div>
          <div class="col-md-6"><label class="form-label">Algus</label><input type="date" name="start_date" class="form-control" required value="<?= e($_POST['start_date'] ?? '') ?>"></div>
          <div class="col-md-6"><label class="form-label">Lõpp</label><input type="date" name="end_date" class="form-control" required value="<?= e($_POST['end_date'] ?? '') ?>"></div>
          <div class="col-12"><button class="btn btn-dark">Arvuta ja salvesta broneering</button></div>
        </form>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
