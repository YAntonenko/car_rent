<?php
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$pageTitle = 'Kasutajad';
$users = get_admin_users();
require_once __DIR__ . '/../inc/header.php';
?>

<section class="container py-4">
    <div class="mb-3">
        <h1 class="h3 mb-1">Kasutajad</h1>
        <p class="text-secondary mb-0">Süsteemi kasutajate nimekiri.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nimi</th>
                            <th>Email</th>
                            <th>Telefon</th>
                            <th>Roll</th>
                            <th>Loodud</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= (int)$user['id'] ?></td>
                            <td><?= e($user['first_name'] . ' ' . $user['last_name']) ?></td>
                            <td><?= e($user['email']) ?></td>
                            <td><?= e($user['phone'] ?? '-') ?></td>
                            <td><span class="badge text-bg-<?= $user['role'] === 'admin' ? 'dark' : 'secondary' ?>"><?= e($user['role']) ?></span></td>
                            <td><?= e($user['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-secondary">Kasutajaid ei leitud.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>
