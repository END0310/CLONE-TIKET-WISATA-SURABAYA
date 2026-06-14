<?php

namespace App\Models;

use CodeIgniter\Model;

class TourismDestinationModel extends Model
{
    protected $table = 'tourism_destinations';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'category_id',
        'name',
        'slug',
        'description',
        'location',
        'image_url',
        'status',
        'is_featured',
    ];
    protected $useTimestamps = true;

    public function getDestinationsWithCategoryAndPrice($categoryId = null)
    {
        $builder = $this->select('
                tourism_destinations.*,
                destination_categories.name AS category_name,
                MIN(ticket_types.price) AS start_price
            ')
            ->join('destination_categories', 'destination_categories.id = tourism_destinations.category_id')
            ->join('ticket_types', 'ticket_types.destination_id = tourism_destinations.id AND ticket_types.is_active = 1', 'left')
            ->groupBy('tourism_destinations.id')
            ->orderBy('tourism_destinations.name', 'ASC');

        if (!empty($categoryId)) {
            $builder->where('tourism_destinations.category_id', $categoryId);
        }

        return $builder->findAll();
    }

    public function getFeaturedDestinations($limit = 8)
    {
        return $this->select('
                tourism_destinations.*,
                destination_categories.name AS category_name,
                MIN(ticket_types.price) AS start_price
            ')
            ->join('destination_categories', 'destination_categories.id = tourism_destinations.category_id')
            ->join('ticket_types', 'ticket_types.destination_id = tourism_destinations.id AND ticket_types.is_active = 1', 'left')
            ->where('tourism_destinations.is_featured', 1)
            ->groupBy('tourism_destinations.id')
            ->orderBy('tourism_destinations.id', 'ASC')
            ->findAll($limit);
    }

    public function getDestinationDetail($id)
    {
        return $this->select('
                tourism_destinations.*,
                destination_categories.name AS category_name
            ')
            ->join('destination_categories', 'destination_categories.id = tourism_destinations.category_id')
            ->where('tourism_destinations.id', $id)
            ->first();
    }
}
