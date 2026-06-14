<?php

namespace App\Models;

use CodeIgniter\Model;

class WebsiteProfileModel extends Model
{
    protected $table = 'website_profile';
    protected $primaryKey = 'id';
    protected $allowedFields = ['site_name','agency_name','tagline','description','logo','hero_image','address','phone','email'];
    protected $useTimestamps = true;
}
