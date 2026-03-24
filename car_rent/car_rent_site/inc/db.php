<?php
require_once __DIR__ . '/config.php';

function db(): mysqli {
    static $conn = null;

    if ($conn instanceof mysqli) {
        return $conn;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die('Andmebaasi ühendus ebaõnnestus: ' . $conn->connect_error);
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}
?>
