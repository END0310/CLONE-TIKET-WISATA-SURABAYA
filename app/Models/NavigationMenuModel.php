<?php

namespace App\Models;

use CodeIgniter\Model;

class NavigationMenuModel extends Model
{
    protected $table = 'navigation_menu';
    protected $primaryKey = 'id';
    protected $allowedFields = ['website_profile_id','parent_id','title','url','sort_order','is_active'];
    protected $useTimestamps = true;
}
