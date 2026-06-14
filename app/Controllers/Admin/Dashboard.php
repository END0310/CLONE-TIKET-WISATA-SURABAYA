<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\ContactMessageModel;
use App\Models\ETicketModel;
use App\Models\TourismDestinationModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $bookingModel = new BookingModel();
        $ticketModel = new ETicketModel();

        return view('admin/dashboard/index', [
            'title' => 'Dashboard Admin',
            'totalDestinations' => (new TourismDestinationModel())->countAllResults(),
            'totalBookings' => $bookingModel->countAllResults(),
            'totalPaid' => $bookingModel->where('payment_status', 'paid')->countAllResults(),
            'totalUnpaid' => $bookingModel->where('payment_status', 'unpaid')->countAllResults(),
            'totalActiveTickets' => $ticketModel->where('ticket_status', 'active')->countAllResults(),
            'totalUsedTickets' => $ticketModel->where('ticket_status', 'used')->countAllResults(),
            'totalMessages' => (new ContactMessageModel())->countAllResults(),
        ]);
    }
}
