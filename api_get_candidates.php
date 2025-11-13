<?php
// Sertakan file konfigurasi database
require 'db_config.php';

try {
    // Ambil semua kandidat dari database, diurutkan berdasarkan NOMOR URUT
    $stmt = $pdo->query("SELECT id_kandidat, no_urut, nama_kandidat, foto_url FROM kandidat ORDER BY no_urut ASC");
    $candidates = $stmt->fetchAll();

    // Ubah key 'id_kandidat' menjadi 'id' dan 'nama_kandidat' menjadi 'name' agar sesuai dengan JS
    $formattedCandidates = [];
    foreach ($candidates as $candidate) {
        $formattedCandidates[] = [
            'id' => $candidate['id_kandidat'],
            'no_urut' => $candidate['no_urut'], // Kirim no_urut ke frontend
            'name' => $candidate['nama_kandidat'],
            'photo' => $candidate['foto_url']
        ];
    }

    // Kirim data kandidat sebagai JSON
    echo json_encode($formattedCandidates);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data kandidat.']);
}
?>