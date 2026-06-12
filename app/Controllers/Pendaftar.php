<?php

namespace App\Controllers;

use App\Models\PendaftarPublikModel;
use App\Models\LandingContentModel;
use App\Models\TblWebModel;

class Pendaftar extends BaseController
{
    public function index()
    {
        $contentModel = new LandingContentModel();
        $content = $contentModel->getContentArray();

        // Check toggled visibility
        if (!isset($content['pendaftar']['is_visible']) || $content['pendaftar']['is_visible'] != '1') {
            return redirect()->to('/');
        }

        $pendaftarModel = new PendaftarPublikModel();
        $tblWebModel = new TblWebModel();

        $search = $this->request->getGet('q');
        
        // Paginating 20 students per page
        $students = $pendaftarModel->getPublicStudents($search, 20);

        // Censor NISN and Nama
        foreach ($students as &$s) {
            $s['nisn'] = $this->censorNisn($s['nisn']);
            $s['nama_lengkap'] = $this->censorNama($s['nama_lengkap']);
        }

        $data = [
            'content' => $content,
            'web' => $tblWebModel->find(1),
            'search' => $search,
            'pendaftar' => $students,
            'pager' => $pendaftarModel->pager,
        ];

        return view('landing/pendaftar', $data);
    }

    private function censorNisn($nisn)
    {
        if (empty($nisn)) return '-';
        $len = strlen($nisn);
        if ($len <= 5) return $nisn;
        return substr($nisn, 0, 5) . str_repeat('*', $len - 5);
    }

    private function censorNama($nama)
    {
        if (empty($nama)) return '-';
        $words = explode(' ', $nama);
        $censoredWords = [];
        foreach ($words as $word) {
            $len = strlen($word);
            if ($len <= 3) {
                // Short words (like 'AB') left as is or minimally censored
                $censoredWords[] = $word;
            } else {
                $censoredWords[] = substr($word, 0, 3) . str_repeat('*', $len - 3);
            }
        }
        return implode(' ', $censoredWords);
    }
}
