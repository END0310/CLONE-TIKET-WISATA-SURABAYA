<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationCategoryModel extends Model
{
    protected $table = 'destination_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description','is_active'];
    protected $useTimestamps = true;
}
