<?php

namespace App\Models;

use CodeIgniter\Model;

class TwibbonStatisticModel extends Model
{
    protected $table            = 'twibbon_statistics';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'campaign_id',
        'ip_address',
        'user_agent'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // No updated_at field in database

    /**
     * Get downloads count grouped by day for a campaign
     */
    public function getDailyStats($campaignId, $days = 7)
    {
        return $this->select("DATE(created_at) as date, COUNT(*) as count")
            ->where('campaign_id', $campaignId)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime("-$days days")))
            ->groupBy("DATE(created_at)")
            ->orderBy("DATE(created_at)", "ASC")
            ->findAll();
    }

    /**
     * Get total downloads count for a campaign
     */
    public function getTotalDownloads($campaignId)
    {
        return $this->where('campaign_id', $campaignId)->countAllResults();
    }
}
