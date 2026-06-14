<?php

namespace App\Controllers;

use App\Models\ETicketModel;

class TicketValidation extends BaseController
{
    public function index()
    {
        return view('validation/index', $this->layoutData(['title' => 'Validasi Tiket']));
    }

    public function check()
    {
        $ticketCode = trim((string) $this->request->getPost('ticket_code'));
        $ticket = (new ETicketModel())->getByTicketCode($ticketCode);

        return view('validation/result', $this->layoutData([
            'title' => 'Hasil Validasi Tiket',
            'ticket' => $ticket,
            'ticketCode' => $ticketCode,
        ]));
    }

    public function useTicket()
    {
        $ticketCode = $this->request->getPost('ticket_code');
        $ticketModel = new ETicketModel();
        $ticket = $ticketModel->where('ticket_code', $ticketCode)->first();

        if ($ticket && $ticket['ticket_status'] === 'active') {
            $ticketModel->update($ticket['id'], ['ticket_status' => 'used', 'used_at' => date('Y-m-d H:i:s')]);
        }

        return redirect()->to('/validate-ticket')->with('success', 'Status tiket diperbarui.');
    }
}
