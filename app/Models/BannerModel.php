<?php

namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model
{
    protected $table = 'banners';
    protected $primaryKey = 'id';
    protected $allowedFields = ['website_profile_id','title','subtitle','image_url','button_text','button_url','is_active'];
    protected $useTimestamps = true;
}
