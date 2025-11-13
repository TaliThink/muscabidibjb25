<?php
require 'db_config.php';

// Ambil data JSON yang dikirim dari frontend
$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'] ?? '';
$npa = $data['npa'] ?? ''; // Tambahkan ini

if (empty($token) || empty($npa)) { // Modifikasi ini
    http_response_code(400); // Bad Request
    echo json_encode(['valid' => false, 'message' => 'Token dan NPA IDI tidak boleh kosong.']); // Modifikasi ini
    exit;
}

try {
    // Siapkan query untuk mencari token DAN npa
    $stmt = $pdo->prepare("SELECT status_penggunaan FROM token_pemilih WHERE token = ? AND npa_idi = ?"); // Modifikasi ini
    $stmt->execute([$token, $npa]); // Modifikasi ini
    $result = $stmt->fetch();

    if ($result) {
        // Token ditemukan
        if ($result['status_penggunaan'] === 'belum_dipakai') {
            // Token valid dan belum dipakai
            echo json_encode(['valid' => true, 'message' => 'Token valid.']);
        } else {
            // Token sudah dipakai
            echo json_encode(['valid' => false, 'message' => 'Token ini sudah digunakan.']);
        }
    } else {
        // Token tidak ditemukan
        echo json_encode(['valid' => false, 'message' => 'Kombinasi Token dan NPA IDI tidak valid.']); // Modifikasi ini
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['valid' => false, 'message' => 'Terjadi kesalahan pada server.']);
}
?>