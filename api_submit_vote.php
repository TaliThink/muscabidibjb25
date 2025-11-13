<?php
require 'db_config.php';

// Ambil data JSON dari frontend
$data = json_decode(file_get_contents('php://input'), true);

$token = $data['token'] ?? '';
$npa = $data['npa'] ?? ''; // Tambahkan ini
$candidate_id = $data['candidate_id'] ?? 0;

if (empty($token) || empty($npa) || empty($candidate_id)) { // Modifikasi ini
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
    exit;
}

try {
    // Mulai Transaksi Database
    // Ini penting untuk memastikan DUA query (simpan suara + update token)
    // berhasil bersama-sama atau gagal bersama-sama.
    $pdo->beginTransaction();

    // 1. Cek token dan dapatkan id_token
    // 'FOR UPDATE' mengunci baris ini untuk mencegah race condition (jika 2 orang pakai token sama di waktu bersamaan)
    $stmt_check = $pdo->prepare("SELECT id_token, status_penggunaan FROM token_pemilih WHERE token = ? AND npa_idi = ? FOR UPDATE"); // Modifikasi ini
    $stmt_check->execute([$token, $npa]); // Modifikasi ini
    $token_data = $stmt_check->fetch();

    // Validasi token sekali lagi
    if (!$token_data) {
        throw new Exception('Kombinasi Token dan NPA IDI tidak ditemukan.'); // Modifikasi ini
    }
    if ($token_data['status_penggunaan'] === 'sudah_dipakai') {
        throw new Exception('Token sudah digunakan.');
    }

    $id_token_pemilih = $token_data['id_token'];

    // 2. Simpan suara ke tabel hasil_suara
    // Database akan menolak jika id_token_pemilih sudah ada (karena UNIQUE KEY)
    $stmt_insert = $pdo->prepare("INSERT INTO hasil_suara (id_kandidat, id_token_pemilih) VALUES (?, ?)");
    $stmt_insert->execute([$candidate_id, $id_token_pemilih]);

    // 3. Update status token menjadi 'sudah_dipakai'
    $stmt_update = $pdo->prepare("UPDATE token_pemilih SET status_penggunaan = 'sudah_dipakai' WHERE id_token = ?");
    $stmt_update->execute([$id_token_pemilih]);

    // Jika semua berhasil, commit transaksi
    $pdo->commit();
    
    echo json_encode(['success' => true, 'message' => 'Suara Anda telah berhasil dicatat.']);

} catch (Exception $e) {
    // Jika terjadi error, batalkan semua perubahan (rollback)
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    // Kirim pesan error yang spesifik jika itu adalah duplikat
    if (str_contains($e->getMessage(), 'Duplicate entry')) {
        echo json_encode(['success' => false, 'message' => 'Gagal: Suara untuk token ini sudah tercatat sebelumnya.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal menyimpan suara: ' . $e->getMessage()]);
    }
}
?>