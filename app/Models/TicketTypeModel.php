<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketTypeModel extends Model
{
    protected $table = 'ticket_types';
    protected $primaryKey = 'id';
    protected $allowedFields = ['destination_id','name','description','price','is_active'];
    protected $useTimestamps = true;
}
