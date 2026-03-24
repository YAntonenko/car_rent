<?php
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$errors = [];
$car = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car = [
        'brand' => trim($_POST['brand'] ?? ''), 'model' => trim($_POST['model'] ?? ''), 'year' => (int)($_POST['year'] ?? 0),
        'registration_number' => trim($_POST['registration_number'] ?? ''), 'price_per_day' => (float)($_POST['price_per_day'] ?? 0),
        'engine' => trim($_POST['engine'] ?? ''), 'fuel_type' => trim($_POST['fuel_type'] ?? ''), 'transmission' => trim($_POST['transmission'] ?? ''),
        'seats' => (int)($_POST['seats'] ?? 0), 'description' => trim($_POST['description'] ?? ''), 'image' => trim($_POST['image'] ?? ''), 'status' => trim($_POST['status'] ?? 'available')
    ];
    if ($car['brand'] === '' || $car['model'] === '' || $car['registration_number'] === '' || $car['image'] === '') { $errors[] = 'Palun täida kõik kohustuslikud väljad.'; }
    if (!$errors) {
        $stmt = db()->prepare('INSERT INTO cars (brand, model, year, registration_number, price_per_day, engine, fuel_type, transmission, seats, description, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssisdsssisss', $car['brand'], $car['model'], $car['year'], $car['registration_number'], $car['price_per_day'], $car['engine'], $car['fuel_type'], $car['transmission'], $car['seats'], $car['description'], $car['image'], $car['status']);
        if ($stmt->execute()) { flash('success', 'Auto lisati edukalt.'); redirect('index.php'); }
        $errors[] = 'Auto lisamine ebaõnnestus.';
    }
}
$pageTitle = 'Lisa auto';
require_once __DIR__ . '/../inc/header.php';
?><section class="container py-5"><?php require __DIR__ . '/form.php'; ?></section><?php require_once __DIR__ . '/../inc/footer.php'; ?>
