<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookingModel;

class BookingAdmin extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/bookings/index', [
            'title' => 'Data Booking',
            'bookings' => (new BookingModel())->getAdminRows(),
        ]);
    }
}
