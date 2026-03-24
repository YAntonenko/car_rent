<?php
require_once __DIR__ . '/db.php';

function e(?string $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function is_admin_logged_in(): bool {
    return !empty($_SESSION['is_admin']);
}

function require_admin(): void {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function flash(string $key, ?string $value = null): ?string {
    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return null;
    }

    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }

    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $message;
}

function current_page(): string {
    return basename($_SERVER['PHP_SELF'] ?? '');
}

function active_nav(array $pages): string {
    return in_array(current_page(), $pages, true) ? 'active' : '';
}

function get_cars(string $search = '', int $limit = 8, int $offset = 0): array {
    $conn = db();

    if ($search !== '') {
        $sql = "SELECT * FROM cars WHERE brand LIKE CONCAT('%', ?, '%') OR model LIKE CONCAT('%', ?, '%') ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $search, $search, $limit, $offset);
    } else {
        $sql = "SELECT * FROM cars ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function count_cars(string $search = ''): int {
    $conn = db();

    if ($search !== '') {
        $sql = "SELECT COUNT(*) AS cnt FROM cars WHERE brand LIKE CONCAT('%', ?, '%') OR model LIKE CONCAT('%', ?, '%')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $search, $search);
    } else {
        $sql = "SELECT COUNT(*) AS cnt FROM cars";
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return (int)($result['cnt'] ?? 0);
}

function get_car(int $id): ?array {
    $conn = db();
    $stmt = $conn->prepare('SELECT * FROM cars WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result ?: null;
}

function get_admin_cars(): array {
    $result = db()->query('SELECT * FROM cars ORDER BY id DESC');
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function get_admin_reservations(): array {
    $sql = "SELECT r.*, c.brand, c.model, u.first_name, u.last_name, u.email
            FROM reservations r
            JOIN cars c ON c.id = r.car_id
            JOIN users u ON u.id = r.user_id
            ORDER BY r.id DESC";
    $result = db()->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function get_admin_users(): array {
    $result = db()->query('SELECT * FROM users ORDER BY id DESC');
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function get_or_create_user(string $firstName, string $lastName, string $email, string $phone = ''): int {
    $conn = db();
    $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $found = $stmt->get_result()->fetch_assoc();
    if ($found) {
        return (int)$found['id'];
    }

    $passwordHash = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);
    $role = 'customer';
    $stmt = $conn->prepare('INSERT INTO users (role, first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('ssssss', $role, $firstName, $lastName, $email, $phone, $passwordHash);
    $stmt->execute();
    return $conn->insert_id;
}

function reservation_overlaps(int $carId, string $startDate, string $endDate): bool {
    $conn = db();
    $status = 'active';
    $stmt = $conn->prepare("SELECT id FROM reservations WHERE car_id = ? AND status IN (?) AND (? <= end_date) AND (? >= start_date) LIMIT 1");
    $stmt->bind_param('isss', $carId, $status, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return (bool)$result;
}

function calculate_total_price(string $startDate, string $endDate, float $pricePerDay): float {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $days = (int)$start->diff($end)->days + 1;
    return max($days, 1) * $pricePerDay;
}

function create_reservation(int $userId, int $carId, string $startDate, string $endDate, float $totalPrice): bool {
    $conn = db();
    $status = 'active';
    $stmt = $conn->prepare('INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('iissds', $userId, $carId, $startDate, $endDate, $totalPrice, $status);
    return $stmt->execute();
}

function status_badge_class(string $status): string {
    return match($status) {
        'available' => 'success',
        'rented' => 'danger',
        'service' => 'warning',
        'active' => 'success',
        'cancelled' => 'secondary',
        'finished' => 'dark',
        default => 'secondary',
    };
}
