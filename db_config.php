<?php
// --- EDIT PENGATURAN INI ---
define('DB_HOST', 's0w008c8oogsogs8o8ooggss');      // Host database Anda (biasanya 'localhost')
define('DB_NAME', 'db_voting_idi');  // Nama database yang Anda buat
define('DB_USER', 'root');           // Username database Anda
define('DB_PASS', 'ncp8IdBecr3H95SnGHbbJp6oFyMQbRy7tWL0MUY93R4Bn56gYoRv9SSll7CSTVxi');               // Password database Anda
// ---------------------------

// Mengatur header untuk output JSON dan CORS
// CORS diperlukan agar HTML bisa 'berbicara' dengan API
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *"); // Izinkan akses dari domain manapun (Untuk produksi, ganti '*' dengan domain Anda)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Menangani pre-flight request (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Buat koneksi database menggunakan PDO (PHP Data Objects)
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Jika koneksi gagal, kirim pesan error
    http_response_code(500);
    echo json_encode(['error' => 'Koneksi database gagal: ' . $e->getMessage()]);
    exit;
}
?>