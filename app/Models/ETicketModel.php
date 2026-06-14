<?php

namespace App\Models;

use CodeIgniter\Model;

class ETicketModel extends Model
{
    protected $table = 'e_tickets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['booking_id','ticket_code','qr_code_text','ticket_status','issued_at','used_at'];
    protected $useTimestamps = true;

    public function getByBookingCode(string $code)
    {
        return $this->select('e_tickets.*, bookings.booking_code, bookings.visitor_name, bookings.visit_date, bookings.visit_day, bookings.visit_time, bookings.quantity, tourism_destinations.name AS destination_name')
            ->join('bookings', 'bookings.id = e_tickets.booking_id')
            ->join('tourism_destinations', 'tourism_destinations.id = bookings.destination_id')
            ->where('bookings.booking_code', $code)
            ->first();
    }

    public function getByTicketCode(string $code)
    {
        return $this->select('e_tickets.*, bookings.booking_code, bookings.visitor_name, bookings.visit_date, bookings.visit_day, bookings.visit_time, bookings.quantity, tourism_destinations.name AS destination_name')
            ->join('bookings', 'bookings.id = e_tickets.booking_id')
            ->join('tourism_destinations', 'tourism_destinations.id = bookings.destination_id')
            ->where('e_tickets.ticket_code', $code)
            ->first();
    }

    public function getAdminRows()
    {
        return $this->select('e_tickets.*, bookings.booking_code, bookings.visitor_name')
            ->join('bookings', 'bookings.id = e_tickets.booking_id')
            ->orderBy('e_tickets.id', 'DESC')
            ->findAll();
    }
}
