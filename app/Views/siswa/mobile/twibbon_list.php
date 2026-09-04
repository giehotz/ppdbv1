<?php
/**
 * View Siswa Mobile Twibbon List
 * Mendelegasikan ke view twibbon utama (app/Views/twibbon/list.php) yang sudah sepenuhnya responsif & mobile-friendly.
 */
if (!isset($web)) {
    $web = (new \App\Models\TblWebModel())->find(1);
}
echo view('siswa/twibbon/list', array_merge(get_defined_vars(), ['web' => $web]));
