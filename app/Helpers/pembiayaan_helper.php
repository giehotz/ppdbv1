<?php

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('status_lunas')) {
    function status_lunas($totalTagihan, $totalBayar)
    {
        return $totalBayar >= $totalTagihan;
    }
}

if (!function_exists('sisa_tagihan')) {
    function sisa_tagihan($totalTagihan, $totalBayar)
    {
        $sisa = $totalTagihan - $totalBayar;
        return $sisa > 0 ? $sisa : 0;
    }
}
