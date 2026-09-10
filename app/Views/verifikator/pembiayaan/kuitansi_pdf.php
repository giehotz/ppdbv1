<?php
$data = compact('siswa', 'tagihan', 'totalTagihan', 'totalLunas', 'totalBayar', 'riwayatBayar');
echo view('siswa/kuitansi_pdf', $data);

