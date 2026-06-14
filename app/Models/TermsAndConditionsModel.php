<?php

namespace App\Models;

use CodeIgniter\Model;

class TermsAndConditionsModel extends Model
{
    protected $table = 'terms_and_conditions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['destination_id','content','sort_order'];
    protected $useTimestamps = true;
}
