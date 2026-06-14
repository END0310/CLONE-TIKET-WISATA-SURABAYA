<?php

namespace App\Controllers;

use App\Models\ETicketModel;

class Ticket extends BaseController
{
    public function show($bookingCode)
    {
        $ticket = (new ETicketModel())->getByBookingCode($bookingCode);

        if (! $ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('E-ticket tidak ditemukan');
        }

        return view('ticket/show', $this->layoutData([
            'title' => 'E-Ticket',
            'ticket' => $ticket,
            'printMode' => false,
        ]));
    }

    public function download($bookingCode)
    {
        $ticket = (new ETicketModel())->getByBookingCode($bookingCode);

        if (! $ticket) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('E-ticket tidak ditemukan');
        }

        return view('ticket/show', $this->layoutData([
            'title' => 'Cetak E-Ticket',
            'ticket' => $ticket,
            'printMode' => true,
        ]));
    }
}
