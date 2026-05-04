<?php require_once __DIR__ . '/inc/functions.php'; $title = 'Avaleht'; require_once __DIR__ . '/inc/header.php'; ?>
<main class="container py-4">
    <section class="hero row align-items-center g-4">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold">Lihtne autorent</h1>
            <p class="lead">Vali sobiv auto ja saada broneeringu soov. Projekt on tehtud PHP, mysqli ja Bootstrap 5 abil.</p>
            <a href="autod.php" class="btn btn-dark">Vaata autosid</a>
        </div>
        <div class="col-md-6">
            <img class="img-fluid rounded" src="https://loremflickr.com/700/420/car?lock=10" alt="Auto">
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
