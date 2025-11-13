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
        /* Style kustom untuk radio button yang dipilih */
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
        // Pastikan file PHP Anda berada di lokasi yang benar.
        // Jika file PHP ada di folder 'api', ganti menjadi 'api/api_get_candidates.php'
        const API_URL = {
            GET_CANDIDATES: 'api_get_candidates.php',
            VALIDATE_TOKEN: 'api_validate_token.php',
            SUBMIT_VOTE: 'api_submit_vote.php'
        };

        // --- DATA KANDIDAT (CONTOH) ---
        // Data ini tidak lagi digunakan, akan diambil dari database.
        // const candidates = [ ... ];
        
        // Variabel global untuk menyimpan data kandidat dari API
        let appCandidates = [];
        
        // --- PENGABILAN ELEMEN DOM ---
        const tokenPage = document.getElementById('token-page');
        const votingPage = document.getElementById('voting-page');
        const thanksPage = document.getElementById('thanks-page');
        const confirmModal = document.getElementById('confirm-modal');
        
        const tokenInput = document.getElementById('token-input');
        const npaInput = document.getElementById('npa-input'); // Tambahkan ini
        const loginButton = document.getElementById('login-button');
        const tokenError = document.getElementById('token-error');
        
        const candidateList = document.getElementById('candidate-list');
        const submitVoteButton = document.getElementById('submit-vote-button');
        const voteError = document.getElementById('vote-error');
        
        const confirmNo = document.getElementById('confirm-no');
        const confirmYes = document.getElementById('confirm-yes');
        const selectedCandidateName = document.getElementById('selected-candidate-name');

        let selectedCandidate = null;

        // --- FUNGSI UNTUK MERENDER KANDIDAT ---
        // Sekarang menerima 'candidates' sebagai argumen
        function renderCandidates(candidates) {
            candidates.forEach(candidate => {
                const candidateElement = document.createElement('div');
                
                // Radio button (disembunyikan)
                const radioInput = document.createElement('input');
                radioInput.type = 'radio';
                radioInput.id = `candidate-${candidate.id}`;
                radioInput.name = 'candidate';
                radioInput.value = candidate.id;
                radioInput.className = 'absolute opacity-0 w-0 h-0';

                // Label yang terlihat (kartu kandidat)
                const label = document.createElement('label');
                label.htmlFor = `candidate-${candidate.id}`;
                label.className = 'flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition duration-200';
                
                label.innerHTML = `
                    <img src="${candidate.photo}" alt="Foto ${candidate.name}" class="w-16 h-16 rounded-full object-cover mr-4 border border-gray-200">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-blue-600">NOMOR URUT ${candidate.no_urut}</span>
                        <span class="text-lg font-medium text-gray-800">${candidate.name}</span>
                    </div>
                    <span class="ml-auto w-6 h-6 border-2 border-gray-400 rounded-full flex items-center justify-center transition-all duration-200">
                        <!-- Lingkaran dalam untuk radio yang dipilih -->
                        <span class="w-3 h-3 bg-blue-600 rounded-full scale-0 transition-transform duration-200"></span>
                    </span>
                `;

                // Update style saat radio dipilih
                radioInput.addEventListener('change', () => {
                    // Reset semua label
                    document.querySelectorAll('input[name="candidate"] + label').forEach(lbl => {
                        lbl.classList.remove('border-blue-600', 'shadow-md');
                        lbl.querySelector('span:last-child').classList.remove('border-blue-600');
                        lbl.querySelector('span:last-child > span').classList.add('scale-0');
                    });
                    
                    // Terapkan style ke label yang dipilih
                    const checkedLabel = document.querySelector(`label[for="candidate-${candidate.id}"]`);
                    checkedLabel.classList.add('border-blue-600', 'shadow-md');
                    checkedLabel.querySelector('span:last-child').classList.add('border-blue-600');
                    checkedLabel.querySelector('span:last-child > span').classList.remove('scale-0');

                    voteError.classList.add('hidden'); // Sembunyikan error jika ada
                });

                candidateElement.appendChild(radioInput);
                candidateList.appendChild(label);
                candidateList.appendChild(candidateElement);
            });
        }

        // --- EVENT LISTENER ---

        // 1. Tombol Login (Validasi Token)
        loginButton.addEventListener('click', async () => {
            const token = tokenInput.value.trim();
            const npa = npaInput.value.trim(); // Tambahkan ini
            
            // Sembunyikan pesan error sebelumnya
            tokenError.classList.add('hidden');

            if (token === '' || npa === '') { // Modifikasi ini
                tokenError.textContent = 'Token dan NPA IDI tidak boleh kosong.'; // Modifikasi ini
                tokenError.classList.remove('hidden');
                return;
            }

            // --- !!! TITIK INTEGRASI BACKEND 1 !!! ---
            // Mengganti simulasi dengan 'fetch' ke API

            // (Simulasi Panggilan API)
            loginButton.disabled = true;
            loginButton.textContent = 'Memvalidasi...';
            
            let isTokenValid = false;
            let validationMessage = 'Token tidak valid atau sudah digunakan.';

            try {
                const response = await fetch(API_URL.VALIDATE_TOKEN, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ token: token, npa: npa }) // Modifikasi ini
                });

                const data = await response.json();

                if (response.ok && data.valid) {
                    isTokenValid = true;
                } else {
                    validationMessage = data.message || validationMessage;
                }

            } catch (error) {
                console.error('Error validating token:', error);
                validationMessage = 'Tidak dapat terhubung ke server validasi.';
            }


            loginButton.disabled = false;
            loginButton.textContent = 'Masuk';
            
            if (isTokenValid) {
                // Jika token valid, AMBIL DATA KANDIDAT dari API
                try {
                    loginButton.textContent = 'Mengambil data kandidat...';
                    loginButton.disabled = true;
                    
                    const candResponse = await fetch(API_URL.GET_CANDIDATES);
                    appCandidates = await candResponse.json(); // Simpan kandidat secara global

                    if (!appCandidates || appCandidates.error) {
                         throw new Error(appCandidates.error || 'Data kandidat tidak ditemukan.');
                    }

                    // Tampilkan halaman voting
                    tokenPage.classList.add('hidden');
                    votingPage.classList.remove('hidden');
                    renderCandidates(appCandidates); // Muat daftar kandidat dari API
                
                } catch (error) {
                    console.error('Error fetching candidates:', error);
                    tokenError.textContent = 'Gagal memuat data kandidat. Coba lagi.';
                    tokenError.classList.remove('hidden');
                    loginButton.textContent = 'Masuk';
                    loginButton.disabled = false;
                }
            } else {
                // Jika token tidak valid
                tokenError.textContent = validationMessage;
                tokenError.classList.remove('hidden');
            }
        });

        // 2. Tombol Kirim Pilihan
        submitVoteButton.addEventListener('click', () => {
            const checkedRadio = document.querySelector('input[name="candidate"]:checked');
            
            if (!checkedRadio) {
                voteError.classList.remove('hidden');
                return;
            }

            voteError.classList.add('hidden');
            
            // Dapatkan data kandidat yang dipilih
            const selectedId = checkedRadio.value;
            // Gunakan 'appCandidates' (dari global) untuk menemukan data
            selectedCandidate = appCandidates.find(c => c.id.toString() === selectedId);

            // Tampilkan di modal konfirmasi
            selectedCandidateName.textContent = selectedCandidate.name;
            confirmModal.classList.remove('hidden');
        });

        // 3. Tombol Batal di Modal Konfirmasi
        confirmNo.addEventListener('click', () => {
            confirmModal.classList.add('hidden');
            selectedCandidate = null;
        });

        // 4. Tombol 'Ya, Yakin' di Modal Konfirmasi
        confirmYes.addEventListener('click', async () => {
            // --- !!! TITIK INTEGRASI BACKEND 2 !!! ---
            // Mengganti simulasi dengan 'fetch' ke API
            
            // (Simulasi Panggilan API)
            confirmYes.disabled = true;
            confirmNo.disabled = true;
            confirmYes.textContent = 'Mengirim...';

            let voteSubmitted = false;
            let submissionMessage = 'Gagal mengirimkan suara. Silakan coba lagi.';

            try {
                const response = await fetch(API_URL.SUBMIT_VOTE, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        token: tokenInput.value.trim(), // Ambil token lagi
                        npa: npaInput.value.trim(), // Tambahkan ini
                        candidate_id: selectedCandidate.id // Ambil ID kandidat
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    voteSubmitted = true;
                } else {
                    submissionMessage = data.message || submissionMessage;
                }

            } catch (error) {
                console.error('Error submitting vote:', error);
                submissionMessage = 'Tidak dapat terhubung ke server. Coba lagi.';
            }

            // Setelah suara berhasil dikirim (voteSubmitted === true)
            if (voteSubmitted) {
                confirmModal.classList.add('hidden');
                votingPage.classList.add('hidden');
                thanksPage.classList.remove('hidden');
            } else {
                // Jika gagal (misal, koneksi terputus)
                // Ganti alert() dengan UI yang lebih baik
                alert(submissionMessage); // 'alert' tidak ideal, tapi ini cara cepat
                confirmYes.disabled = false;
                confirmNo.disabled = false;
                confirmYes.textContent = 'Ya, Saya Yakin';
            }
        });

    </script>
</body>
</html>