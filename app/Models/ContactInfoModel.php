<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactInfoModel extends Model
{
    protected $table = 'contact_infos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['website_profile_id','type','label','value','is_active'];
    protected $useTimestamps = true;
}
