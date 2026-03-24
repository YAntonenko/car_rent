<?php $editing = isset($car) && !empty($car['id']); $actionLabel = $editing ? 'Muuda autot' : 'Lisa auto'; ?>
<div class="bg-white rounded-4 shadow-sm p-4">
  <h1 class="h3 mb-4"><?= $actionLabel ?></h1>
  <?php foreach ($errors as $error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endforeach; ?>
  <form method="post" class="row g-3">
    <div class="col-md-6"><label class="form-label">Mark</label><input type="text" name="brand" class="form-control" required value="<?= e($car['brand'] ?? '') ?>"></div>
    <div class="col-md-6"><label class="form-label">Mudel</label><input type="text" name="model" class="form-control" required value="<?= e($car['model'] ?? '') ?>"></div>
    <div class="col-md-4"><label class="form-label">Aasta</label><input type="number" name="year" class="form-control" required value="<?= e((string)($car['year'] ?? date('Y'))) ?>"></div>
    <div class="col-md-4"><label class="form-label">Reg. number</label><input type="text" name="registration_number" class="form-control" required value="<?= e($car['registration_number'] ?? '') ?>"></div>
    <div class="col-md-4"><label class="form-label">Hind / päev</label><input type="number" step="0.01" name="price_per_day" class="form-control" required value="<?= e((string)($car['price_per_day'] ?? '')) ?>"></div>
    <div class="col-md-6"><label class="form-label">Mootor</label><input type="text" name="engine" class="form-control" required value="<?= e($car['engine'] ?? '') ?>"></div>
    <div class="col-md-6"><label class="form-label">Pildi URL</label><input type="url" name="image" class="form-control" required value="<?= e($car['image'] ?? '') ?>"></div>
    <div class="col-md-4"><label class="form-label">Kütus</label><input type="text" name="fuel_type" class="form-control" required value="<?= e($car['fuel_type'] ?? '') ?>"></div>
    <div class="col-md-4"><label class="form-label">Käigukast</label><input type="text" name="transmission" class="form-control" required value="<?= e($car['transmission'] ?? '') ?>"></div>
    <div class="col-md-4"><label class="form-label">Kohad</label><input type="number" name="seats" class="form-control" required value="<?= e((string)($car['seats'] ?? 5)) ?>"></div>
    <div class="col-md-6"><label class="form-label">Staatus</label><select name="status" class="form-select"><?php foreach (['available','rented','service'] as $val): ?><option value="<?= $val ?>" <?= (($car['status'] ?? '') === $val) ? 'selected' : '' ?>><?= $val ?></option><?php endforeach; ?></select></div>
    <div class="col-12"><label class="form-label">Kirjeldus</label><textarea name="description" rows="4" class="form-control"><?= e($car['description'] ?? '') ?></textarea></div>
    <div class="col-12 d-flex gap-2"><button class="btn btn-dark"><?= $editing ? 'Salvesta muudatused' : 'Lisa auto' ?></button><a href="index.php" class="btn btn-outline-secondary">Tagasi</a></div>
  </form>
</div>
