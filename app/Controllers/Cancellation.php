<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\CancellationModel;
use App\Models\ETicketModel;

class Cancellation extends BaseController
{
    public function index()
    {
        return view('cancellation/index', $this->layoutData(['title' => 'Pembatalan Tiket']));
    }

    public function requestCancel()
    {
        $bookingCode = trim((string) $this->request->getPost('booking_code'));
        $reason = trim((string) $this->request->getPost('reason'));

        if ($bookingCode === '' || $reason === '') {
            return redirect()->back()->withInput()->with('error', 'Kode booking dan alasan wajib diisi.');
        }

        $bookingModel = new BookingModel();
        $booking = $bookingModel->where('booking_code', $bookingCode)->first();

        if (! $booking || $booking['booking_status'] === 'cancelled') {
            return redirect()->back()->withInput()->with('error', 'Booking tidak ditemukan atau sudah dibatalkan.');
        }

        $cancelModel = new CancellationModel();
        $existing = $cancelModel->where('booking_id', $booking['id'])->first();
        $cancelCode = $existing['cancellation_code'] ?? 'CAN-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        if (! $existing) {
            $cancelModel->insert([
                'booking_id' => $booking['id'],
                'cancellation_code' => $cancelCode,
                'reason' => $reason,
                'cancellation_status' => 'requested',
                'requested_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $bookingModel->update($booking['id'], ['booking_status' => 'cancelled']);
        (new ETicketModel())->where('booking_id', $booking['id'])->set(['ticket_status' => 'cancelled'])->update();

        return redirect()->to('/cancellation/status/' . $cancelCode);
    }

    public function status($cancelCode)
    {
        $cancellation = (new CancellationModel())->getByCode($cancelCode);

        if (! $cancellation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pembatalan tidak ditemukan');
        }

        return view('cancellation/status', $this->layoutData([
            'title' => 'Status Pembatalan',
            'cancellation' => $cancellation,
        ]));
    }
}
