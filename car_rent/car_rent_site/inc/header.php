<?php require_once __DIR__ . '/functions.php';
$script = $_SERVER['PHP_SELF'] ?? '';
$basePath = (str_contains($script, '/public/') || str_contains($script, '/admin/')) ? '../' : '';
?>
<!doctype html>
<html lang="et">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle ?? SITE_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= e($basePath) ?>assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= str_contains($script, '/admin/') ? 'index.php' : 'index.php' ?>"><?= str_contains($script, '/admin/') ? 'Autorent admin' : 'Autorent' ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <?php if (!str_contains($script, '/admin/')): ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link <?= active_nav(['index.php']) ?>" href="index.php">Avaleht</a></li>
        <li class="nav-item"><a class="nav-link <?= active_nav(['autod.php', 'auto.php']) ?>" href="autod.php">Autod</a></li>
        <li class="nav-item"><a class="nav-link <?= active_nav(['hinnad.php']) ?>" href="hinnad.php">Hinnad</a></li>
        <li class="nav-item"><a class="nav-link <?= active_nav(['kontakt.php']) ?>" href="kontakt.php">Kontakt</a></li>
      </ul>
      <form class="d-flex" method="get" action="autod.php">
        <input class="form-control me-2" type="search" name="q" placeholder="Otsi marki või mudelit" value="<?= e($_GET['q'] ?? '') ?>">
        <button class="btn btn-dark" type="submit">Otsi</button>
      </form>
      <?php else: ?>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link fw-semibold <?= active_nav(['index.php']) ?>" href="index.php">Autod</a></li>
        <li class="nav-item"><a class="nav-link <?= active_nav(['reservations.php']) ?>" href="reservations.php">Reserveeringud</a></li>
        <li class="nav-item"><a class="nav-link <?= active_nav(['users.php']) ?>" href="users.php">Kasutajad</a></li>
      </ul>
      <?php if (is_admin_logged_in()): ?>
        <a class="btn btn-outline-secondary btn-sm" href="logout.php">Logout</a>
      <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main>
