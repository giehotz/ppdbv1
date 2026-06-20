<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?> Detail Pesan <?= $this->endSection() ?>

<?= $this->section('page_title') ?> Detail Pesan <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Back Button -->
<a href="<?= base_url('siswa/pesan') ?>" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-500 mb-4 active:text-emerald-600 transition">
    <i class="fas fa-arrow-left"></i> Kembali ke Kotak Masuk
</a>

<!-- Message Card Glass -->
<div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 overflow-hidden">
    
    <!-- Subject Header -->
    <div class="bg-gradient-to-r from-slate-50/80 to-slate-100/50 px-5 py-4 border-b border-slate-200/30">
        <h3 class="text-sm font-black text-slate-800 leading-snug">
            <?= esc($pesan['subjek']) ?>
        </h3>
    </div>

    <!-- Sender Info -->
    <div class="px-5 py-4 border-b border-slate-100/30">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-base flex-shrink-0">
                    <?= strtoupper(substr($pesan['nama_pengirim'], 0, 1)) ?>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-800"><?= esc($pesan['nama_pengirim']) ?></p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider <?= $pesan['pengirim_type'] == 'admin' ? 'bg-purple-100/80 text-purple-700' : 'bg-indigo-100/80 text-indigo-700' ?>">
                        <?= ucfirst($pesan['pengirim_type']) ?>
                    </span>
                </div>
            </div>
            <div class="text-right">
                <span class="text-[10px] text-slate-400 bg-slate-50/60 backdrop-blur-sm px-2.5 py-1 rounded-full border border-slate-200/30">
                    <i class="far fa-clock mr-1"></i>
                    <?= date('d M Y', strtotime($pesan['created_at'])) ?>
                </span>
                <p class="text-[10px] text-slate-400 mt-1"><?= date('H:i', strtotime($pesan['created_at'])) ?> WIB</p>
            </div>
        </div>
    </div>

    <!-- Message Body -->
    <div class="px-5 py-5">
        <div class="text-xs text-slate-700 leading-relaxed whitespace-pre-wrap bg-slate-50/60 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/30"><?= esc($pesan['isi_pesan']) ?></div>
    </div>
</div>

<!-- Back to Inbox -->
<div class="mt-5 mb-4">
    <a href="<?= base_url('siswa/pesan') ?>" class="w-full flex items-center justify-center gap-2 py-3 bg-slate-100/80 backdrop-blur-sm hover:bg-slate-200/80 active:bg-slate-300/80 text-slate-700 text-[10px] font-bold rounded-xl transition active:scale-[0.97] border border-slate-200/30">
        <i class="fas fa-arrow-left"></i> Kembali ke Kotak Masuk
    </a>
</div>

<?= $this->endSection() ?>
