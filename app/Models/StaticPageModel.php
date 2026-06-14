<?php

namespace App\Models;

use CodeIgniter\Model;

class StaticPageModel extends Model
{
    protected $table = 'static_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['website_profile_id','title','slug','content','is_active'];
    protected $useTimestamps = true;
}
