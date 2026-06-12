<?= $this->extend('layouts/siswa_mobile') ?>

<?= $this->section('title') ?> Kotak Masuk <?= $this->endSection() ?>

<?= $this->section('page_title') ?> Kotak Masuk <?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="flex items-center p-3 mb-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs font-bold">
        <i class="fas fa-check-circle mr-2 text-emerald-500"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="flex items-center p-3 mb-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-2xl text-xs font-bold">
        <i class="fas fa-exclamation-triangle mr-2 text-rose-500"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Header Card -->
<div class="bg-gradient-to-r from-rose-500 to-pink-600 rounded-3xl p-5 mb-5 shadow-lg">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/30">
            <i class="fas fa-inbox text-white text-xl"></i>
        </div>
        <div>
            <h3 class="text-white text-lg font-black">Kotak Masuk</h3>
            <p class="text-rose-100 text-xs">
                <?= !empty($pesan) ? count($pesan) . ' pesan' : 'Belum ada pesan' ?>
            </p>
        </div>
    </div>
</div>

<!-- Message List -->
<div class="space-y-3">
    <?php if (!empty($pesan)): ?>
        <?php foreach ($pesan as $p): ?>
            <a href="<?= base_url('siswa/pesan/detail/' . $p['id_pesan']) ?>" 
               class="block bg-white rounded-3xl shadow-sm border <?= $p['status'] == 'unread' ? 'border-blue-200 bg-blue-50/30' : 'border-slate-100' ?> overflow-hidden active:scale-[0.98] transition-all duration-200">
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <!-- Avatar -->
                        <div class="w-11 h-11 rounded-2xl <?= $p['status'] == 'unread' ? 'bg-blue-600' : 'bg-slate-300' ?> flex items-center justify-center text-white font-black text-lg flex-shrink-0">
                            <?= strtoupper(substr($p['nama_pengirim'], 0, 1)) ?>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="text-sm <?= $p['status'] == 'unread' ? 'font-black text-slate-900' : 'font-semibold text-slate-600' ?> truncate">
                                        <?= esc($p['nama_pengirim']) ?>
                                    </span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-black uppercase tracking-wider <?= $p['pengirim_type'] == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-indigo-100 text-indigo-700' ?> flex-shrink-0">
                                        <?= ucfirst($p['pengirim_type']) ?>
                                    </span>
                                </div>
                                <?php if ($p['status'] == 'unread'): ?>
                                    <span class="w-2.5 h-2.5 bg-blue-600 rounded-full flex-shrink-0 ml-2"></span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="text-xs <?= $p['status'] == 'unread' ? 'font-bold text-slate-800' : 'font-medium text-slate-500' ?> truncate mb-1">
                                <?= esc($p['subjek']) ?>
                            </p>
                            
                            <p class="text-[11px] text-slate-400 truncate">
                                <?= substr(strip_tags($p['isi_pesan']), 0, 60) ?>...
                            </p>
                            
                            <p class="text-[10px] text-slate-400 mt-1.5">
                                <i class="far fa-clock mr-1"></i>
                                <?= date('d M Y, H:i', strtotime($p['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Empty State -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-3xl text-slate-300"></i>
            </div>
            <p class="text-sm font-bold text-slate-700 mb-1">Kotak Masuk Kosong</p>
            <p class="text-xs text-slate-400">Belum ada pesan masuk dari panitia.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
