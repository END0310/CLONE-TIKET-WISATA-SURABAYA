<?php

namespace App\Models;

use CodeIgniter\Model;

class CancellationModel extends Model
{
    protected $table = 'cancellations';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_id','cancellation_code','reason','cancellation_status','requested_at','approved_at'];
    protected $useTimestamps = true;

    public function getByCode(string $code)
    {
        return $this->select('cancellations.*, bookings.booking_code, bookings.visitor_name, bookings.booking_status')
            ->join('bookings', 'bookings.id = cancellations.booking_id')
            ->where('cancellations.cancellation_code', $code)
            ->first();
    }
}
