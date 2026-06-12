<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= esc($app_alias ?? 'PPDB') ?> Online</title>

    <?php
    $page_title = 'Login - ' . ($app_alias ?? 'PPDB');
    ?>
    <?= view('partials/_seo_meta', ['page_title' => $page_title]) ?>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center relative overflow-hidden font-sans selection:bg-emerald-200 selection:text-emerald-900 px-4">

    <!-- Bentuk Latar Belakang Hiasan -->
    <div class="absolute inset-0 w-full h-full pointer-events-none z-0">
        <div class="absolute -top-[20%] -left-[10%] w-[60vw] h-[60vw] max-w-[600px] max-h-[600px] bg-emerald-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[0%] -right-[10%] w-[50vw] h-[50vw] max-w-[500px] max-h-[500px] bg-blue-200/40 rounded-full blur-3xl"></div>
    </div>

    <!-- Kad Log Masuk Utama -->
    <div class="bg-white/80 backdrop-blur-xl p-8 sm:p-10 rounded-[2rem] shadow-[0_8px_40px_rgb(0,0,0,0.04)] border border-white w-full max-w-md relative z-10">
        
        <!-- Pengepala -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-5 text-emerald-600 text-3xl shadow-sm border border-emerald-50">
                <i class="fas fa-user-graduate"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">Login <?= esc($app_alias ?? 'PPDB') ?></h1>
            <p class="text-slate-500 text-sm mt-2 font-medium">Masuk untuk mengelola data pendaftaran Anda</p>
        </div>

        <!-- Borang Log Masuk -->
        <form action="<?= base_url('/auth/login') ?>" method="post" class="space-y-5">
            <?= csrf_field() ?>
            
            <!-- Input Nama Pengguna -->
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="username">
                    Username / NISN / Email
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-user text-slate-400"></i>
                    </div>
                    <input class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all placeholder:text-slate-400" 
                           id="username" name="username" type="text" placeholder="Masukkan ID Anda" required>
                </div>
            </div>

            <!-- Input Kata Laluan -->
            <div>
                <label class="block text-slate-700 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-slate-400"></i>
                    </div>
                    <input class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all placeholder:text-slate-400" 
                           id="password" name="password" type="password" placeholder="••••••••••••" required>
                </div>
                
                <!-- Pautan Lupa Kata Laluan -->
                <div class="flex justify-end mt-2">
                    <button type="button" onclick="openForgotModal()" class="text-sm text-red-500 hover:text-red-600 font-semibold transition-colors">
                        Lupa Password?
                    </button>
                </div>
            </div>

            <!-- Butang Hantar -->
            <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 shadow-lg shadow-emerald-500/30 hover:-translate-y-0.5 flex items-center justify-center gap-2" type="submit">
                <span>Sign In</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-center text-slate-600 text-sm font-medium">
                Belum punya akun?
                <a href="<?= base_url('/auth/register') ?>" class="text-emerald-600 hover:text-emerald-700 font-bold transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>

        <div class="text-center mt-6">
            <a href="<?= base_url('/') ?>" class="inline-flex items-center justify-center text-sm text-slate-500 hover:text-slate-800 font-medium transition-colors bg-white hover:bg-slate-50 px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                <i class="fas fa-home mr-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Modal Lupa Kata Laluan -->
    <div id="modal-forgot-pw" class="fixed inset-0 z-50 hidden">
        <!-- Latar Belakang Gelap -->
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop" onclick="closeForgotModal()"></div>
        
        <!-- Kandungan Modal -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md transform transition-all scale-95 opacity-0" id="modal-panel">
                <form action="<?= base_url('/auth/forgot-password') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="px-8 pt-8 pb-6">
                        <div class="flex items-center mb-6">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-amber-100 border border-amber-200">
                                <i class="fas fa-key text-amber-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-extrabold text-slate-800">Lupa Password</h3>
                                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider mt-0.5">Pemulihan Akun</p>
                            </div>
                        </div>
                        
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                            Masukkan nama lengkap dan NIK Anda sesuai data pendaftaran. Admin akan memverifikasi permohonan Anda sebelum mereset password.
                        </p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-slate-700 text-sm font-bold mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all placeholder:text-slate-400" placeholder="Sesuai akta/ijazah" required>
                            </div>
                            <div>
                                <label class="block text-slate-700 text-sm font-bold mb-2">NIK (16 Digit)</label>
                                <input type="text" name="nik" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 focus:outline-none focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 transition-all placeholder:text-slate-400" placeholder="Contoh: 3171234567890001" maxlength="16" pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 px-8 py-5 border-t border-slate-100 rounded-b-[2rem] flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button type="button" onclick="closeForgotModal()" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold rounded-xl transition-colors text-sm shadow-sm text-center">
                            Batal
                        </button>
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all shadow-md shadow-amber-500/30 flex items-center justify-center gap-2 text-sm">
                            <i class="fas fa-paper-plane"></i> Kirim Permohonan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Pengendali Modal
        function openForgotModal() {
            const modal = document.getElementById('modal-forgot-pw');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');
            
            modal.classList.remove('hidden');
            
            // Benarkan paparan digunakan sebelum mula animasi
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('scale-95', 'opacity-0');
                panel.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeForgotModal() {
            const modal = document.getElementById('modal-forgot-pw');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');
            
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('scale-100', 'opacity-100');
            panel.classList.add('scale-95', 'opacity-0');
            
            // Tunggu transisi selesai
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); 
        }

        // Tutup modal dengan kekunci escape
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeForgotModal();
        });

        // Notifikasi SweetAlert
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('success')): ?>
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Berhasil!', 
                    html: <?= json_encode(session()->getFlashdata('success')) ?>, 
                    timer: 4000, 
                    timerProgressBar: true, 
                    showConfirmButton: false, 
                    toast: true, 
                    position: 'top-end',
                    customClass: { popup: 'rounded-xl shadow-lg border border-slate-100' }
                });
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('msg')): ?>
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Perhatian', 
                    html: <?= json_encode(session()->getFlashdata('msg')) ?>, 
                    confirmButtonColor: '#10b981', // emerald-500
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 font-bold shadow-md'
                    }
                });
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Login Gagal', 
                    html: <?= json_encode(session()->getFlashdata('error')) ?>, 
                    confirmButtonColor: '#ef4444',
                    customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-6 font-bold' }
                });
            <?php endif; ?>
        });
    </script>
</body>

</html>