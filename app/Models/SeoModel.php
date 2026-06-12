<?php

namespace App\Models;

use CodeIgniter\Model;

class SeoModel extends Model
{
    protected $table            = 'site_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'site_name',
        'meta_title_suffix',
        'meta_description',
        'meta_keywords',
        'og_image',
        'google_analytics',
        'updated_at',
    ];

    protected $useTimestamps = false;
}
