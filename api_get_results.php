<?php
// Sertakan file konfigurasi database
// Ini akan menyediakan variabel $pdo
require 'db_config.php';

try {
    // 1. Ambil Perolehan Suara per Kandidat
    // Kita join tabel kandidat dengan hasil_suara
    // Kita gunakan LEFT JOIN agar kandidat dengan 0 suara tetap muncul
    // Kita hitung (COUNT) jumlah suara dan kelompokkan (GROUP BY)
    $stmt_results = $pdo->query("
        SELECT
            k.no_urut,
            k.nama_kandidat,
            k.foto_url,
            COUNT(hs.id_suara) AS jumlah_suara
        FROM
            kandidat AS k
        LEFT JOIN
            hasil_suara AS hs ON k.id_kandidat = hs.id_kandidat
        GROUP BY
            k.id_kandidat
        ORDER BY
            k.no_urut ASC
    ");
    $perolehan_suara = $stmt_results->fetchAll();

    // 2. Ambil Statistik Total
    // Menghitung total pemilih (hak suara) dari tabel token_pemilih
    $stmt_total_pemilih = $pdo->query("SELECT COUNT(*) FROM token_pemilih");
    $total_pemilih = (int)$stmt_total_pemilih->fetchColumn();

    // Menghitung total suara yang sudah masuk
    $stmt_total_suara = $pdo->query("SELECT COUNT(*) FROM hasil_suara");
    $total_suara_masuk = (int)$stmt_total_suara->fetchColumn();

    // 3. Hitung Persentase Partisipasi
    $persentase_masuk = 0;
    if ($total_pemilih > 0) {
        $persentase_masuk = ($total_suara_masuk / $total_pemilih) * 100;
    }

    // 4. Siapkan data untuk dikirim sebagai JSON
    $response = [
        'perolehan_suara' => $perolehan_suara,
        'statistik' => [
            'total_pemilih' => $total_pemilih,
            'total_suara_masuk' => $total_suara_masuk,
            'persentase_masuk' => round($persentase_masuk, 2) // Bulatkan 2 angka desimal
        ]
    ];

    // Kirim respons
    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal mengambil data hasil: ' . $e->getMessage()]);
}
?>