<?php
/**
 * View Siswa Mobile Twibbon Detail
 * Mendelegasikan ke view twibbon utama (app/Views/twibbon/detail.php) yang sudah sepenuhnya responsif & mobile-friendly.
 */
if (!isset($web)) {
    $web = (new \App\Models\TblWebModel())->find(1);
}
echo view('siswa/twibbon/detail', array_merge(get_defined_vars(), ['web' => $web]));
