<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ETicketModel;

class TicketAdmin extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/tickets/index', [
            'title' => 'Data E-Ticket',
            'tickets' => (new ETicketModel())->getAdminRows(),
        ]);
    }
}
