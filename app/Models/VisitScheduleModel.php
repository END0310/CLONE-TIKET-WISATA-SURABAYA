<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitScheduleModel extends Model
{
    protected $table = 'visit_schedules';
    protected $primaryKey = 'id';
    protected $allowedFields = ['destination_id','day_name','open_time','close_time','quota','is_closed'];
    protected $useTimestamps = true;
}
