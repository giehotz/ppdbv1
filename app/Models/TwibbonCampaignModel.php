<?php

namespace App\Models;

use CodeIgniter\Model;

class TwibbonCampaignModel extends Model
{
    protected $table            = 'twibbon_campaigns';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all active campaigns
     */
    public function getActiveCampaigns()
    {
        $today = date('Y-m-d');
        return $this->where('is_active', 1)
            ->groupStart()
                ->where('start_date <=', $today)
                ->orWhere('start_date', null)
            ->groupEnd()
            ->groupStart()
                ->where('end_date >=', $today)
                ->orWhere('end_date', null)
            ->groupEnd()
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }
}
