<?php

namespace App\Models;

use CodeIgniter\Model;

class LandingContentModel extends Model
{
    protected $table            = 'tbl_landing_content';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'section',
        'content_key',
        'content_value',
        'media_path',
        'order_index',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all content grouped by section
     */
    public function getContentBySection($section = null)
    {
        if ($section) {
            return $this->where('section', $section)
                ->where('is_active', 1)
                ->orderBy('order_index', 'ASC')
                ->findAll();
        }

        return $this->where('is_active', 1)
            ->orderBy('section', 'ASC')
            ->orderBy('order_index', 'ASC')
            ->findAll();
    }

    /**
     * Update or insert content
     */
    public function upsertContent($section, $contentKey, $data)
    {
        $existing = $this->where('section', $section)
            ->where('content_key', $contentKey)
            ->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['section'] = $section;
            $data['content_key'] = $contentKey;
            return $this->insert($data);
        }
    }

    /**
     * Get all content as associative array for easy access
     */
    public function getContentArray()
    {
        $contents = $this->where('is_active', 1)->findAll();
        $result = [];

        foreach ($contents as $content) {
            if (!isset($result[$content['section']])) {
                $result[$content['section']] = [];
            }
            $result[$content['section']][$content['content_key']] = $content['content_value'];
        }

        return $result;
    }
}
