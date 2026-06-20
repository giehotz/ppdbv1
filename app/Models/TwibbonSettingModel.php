<?php

namespace App\Models;

use CodeIgniter\Model;

class TwibbonSettingModel extends Model
{
    protected $table            = 'twibbon_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cleanup_enabled',
        'results_ttl_hours',
        'temp_ttl_hours',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';

    public function getSettings(): array
    {
        $settings = $this->find(1);
        if (!$settings) {
            $this->insert([
                'cleanup_enabled'   => 1,
                'results_ttl_hours' => 12,
                'temp_ttl_hours'    => 1,
            ]);
            $settings = $this->find(1);
        }
        return $settings;
    }
}
