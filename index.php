<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting Ketua IDI Banjarbaru 2025-2028</title>
    <!-- Memuat Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Memuat font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Menggunakan font Inter sebagai default */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Style kustom untuk radio button yang dipilih (backup, selain JS) */
        input[type="radio"]:checked + label {
            border-color: #2563eb; /* blue-600 */
            box-shadow: 0 0 0 2px #2563eb; /* blue-600 */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <!-- Kontainer Utama Aplikasi -->
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl overflow-hidden">
        
        <!-- Header -->
        <div class="bg-blue-600 p-6 text-white text-center">
            <h1 class="text-2xl font-bold">E-Voting Ketua IDI</h1>
            <p class="text-lg font-light">Cabang Banjarbaru 2025-2028</p>
        </div>

        <div class="p-6 md:p-8">

            <!-- Bagian 1: Halaman Input Token (Default) -->
            <div id="token-page">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Selamat Datang, Dokter!</h2>
                <p class="text-gray-600 mb-6">Silakan masukkan kode voting (token) unik Anda untuk melanjutkan.</p>
                
                <div class="space-y-4">
                    <div>
                        <label for="token-input" class="block text-sm font-medium text-gray-700 mb-1">Kode Voting</label>
                        <input type="text" id="token-input" placeholder="Masukkan token Anda di sini"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               aria-label="Kode Voting">
                    </div>

                    <div>
                        <label for="npa-input" class="block text-sm font-medium text-gray-700 mb-1">Nomor NPA IDI</label>
                        <input type="text" id="npa-input" placeholder="Masukkan Nomor NPA IDI Anda"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                               aria-label="Nomor NPA IDI">
                    </div>
                    
                    <!-- Pesan Error Token -->
                    <p id="token-error" class="text-red-600 text-sm hidden">Token tidak valid atau sudah digunakan. Silakan coba lagi.</p>

                    <button id="login-button" 
                            class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 ease-in-out">
                        Masuk
                    </button>
                </div>
            </div>

            <!-- Bagian 2: Halaman Voting (Hidden) -->
            <div id="voting-page" class="hidden">
                <h2 class="text-xl font-semibold text-gray-800 mb-1">Silakan Pilih Calon Anda</h2>
                <p class="text-gray-600 mb-6">Pilih salah satu kandidat di bawah ini. Pilihan Anda bersifat rahasia.</p>
                
                <!-- Daftar Kandidat (Akan di-generate oleh JavaScript) -->
                <div id="candidate-list" class="space-y-4">
                    <!-- Contoh kandidat akan dimuat di sini -->
                </div>

                <!-- Pesan Error Pilihan -->
                <p id="vote-error" class="text-red-600 text-sm mt-4 hidden">Anda harus memilih salah satu kandidat.</p>

                <button id="submit-vote-button"
                        class="w-full bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition duration-300 ease-in-out mt-8">
                    Kirim Pilihan Saya
                </button>
            </div>

            <!-- Bagian 3: Modal Konfirmasi (Hidden) -->
            <div id="confirm-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-sm text-center">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfirmasi Pilihan</h3>
                    <p class="text-gray-700 mb-6">
                        Anda telah memilih: <strong id="selected-candidate-name" class="text-blue-600"></strong>.
                        <br><br>
                        Apakah Anda yakin dengan pilihan ini? Pilihan tidak dapat diubah setelah dikonfirmasi.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button id="confirm-no" class="px-6 py-2 rounded-lg bg-gray-200 text-gray-800 hover:bg-gray-300 font-medium transition duration-200">Batal</button>
                        <button id="confirm-yes" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 font-medium transition duration-200 shadow-md">Ya, Saya Yakin</button>
                    </div>
                </div>
            </div>

            <!-- Bagian 4: Halaman Terima Kasih (Hidden) -->
            <div id="thanks-page" class="hidden text-center">
                <svg class="w-20 h-20 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Terima Kasih!</h2>
                <p class="text-gray-600 text-lg">Suara Anda telah berhasil dicatat.</p>
                <p class="text-gray-500 mt-4">Terima kasih atas partisipasi Anda dalam pemilihan Ketua IDI Cabang Banjarbaru periode 2025-2028.</p>
            </div>

        </div>
    </div>

    <script>
        // --- URL API ANDA ---
        // Pastikan file P
