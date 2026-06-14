<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (session()->get('userRole') === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        $bookingModel = new BookingModel();
        $bookings = $bookingModel->select('bookings.*, tourism_destinations.name AS destination_name')
            ->join('tourism_destinations', 'tourism_destinations.id = bookings.destination_id')
            ->where('bookings.visitor_email', session()->get('userEmail'))
            ->orderBy('bookings.id', 'DESC')
            ->findAll();

        return view('user/dashboard', $this->layoutData([
            'title' => 'Dashboard Pengguna',
            'bookings' => $bookings,
        ]));
    }
}
