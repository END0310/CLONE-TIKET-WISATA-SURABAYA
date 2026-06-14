<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_code','destination_id','ticket_type_id','visitor_name','visitor_email','visitor_phone','visit_date','visit_day','visit_time','quantity','ticket_price','total_price','booking_status','payment_status','notes'];
    protected $useTimestamps = true;

    public function getDetailByCode(string $code)
    {
        return $this->select('bookings.*, tourism_destinations.name AS destination_name, tourism_destinations.location, ticket_types.name AS ticket_name')
            ->join('tourism_destinations', 'tourism_destinations.id = bookings.destination_id')
            ->join('ticket_types', 'ticket_types.id = bookings.ticket_type_id')
            ->where('bookings.booking_code', $code)
            ->first();
    }

    public function getAdminRows()
    {
        return $this->select('bookings.*, tourism_destinations.name AS destination_name')
            ->join('tourism_destinations', 'tourism_destinations.id = bookings.destination_id')
            ->orderBy('bookings.id', 'DESC')
            ->findAll();
    }
}
