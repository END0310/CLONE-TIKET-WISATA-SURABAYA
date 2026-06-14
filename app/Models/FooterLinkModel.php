<?php

namespace App\Models;

use CodeIgniter\Model;

class FooterLinkModel extends Model
{
    protected $table = 'footer_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['website_profile_id','title','url','group_name','sort_order','is_active'];
    protected $useTimestamps = true;
}
