<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_id','payment_code','payment_method','payment_amount','payment_status','paid_at','proof_image'];
    protected $useTimestamps = true;

    public function getAdminRows()
    {
        return $this->select('payments.*, bookings.booking_code, bookings.visitor_name')
            ->join('bookings', 'bookings.id = payments.booking_id')
            ->orderBy('payments.id', 'DESC')
            ->findAll();
    }
}
