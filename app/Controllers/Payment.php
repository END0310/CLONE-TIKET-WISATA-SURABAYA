<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\PaymentModel;
use App\Models\ETicketModel;

class Payment extends BaseController
{
    public function index($bookingCode)
    {
        $booking = (new BookingModel())->getDetailByCode($bookingCode);

        if (! $booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Booking tidak ditemukan');
        }

        return view('payment/index', $this->layoutData([
            'title' => 'Pembayaran',
            'booking' => $booking,
        ]));
    }

    public function process()
    {
        $bookingCode = $this->request->getPost('booking_code');
        $method = $this->request->getPost('payment_method');
        $bookingModel = new BookingModel();
        $booking = $bookingModel->where('booking_code', $bookingCode)->first();

        if (! $booking || ! in_array($method, ['QRIS', 'Transfer Bank', 'E-Wallet'], true)) {
            return redirect()->to('/payment/failed/' . $bookingCode);
        }

        $paymentModel = new PaymentModel();
        $payment = $paymentModel->where('booking_id', $booking['id'])->first();
        $paymentData = [
            'booking_id' => $booking['id'],
            'payment_code' => $payment['payment_code'] ?? 'PAY-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4)),
            'payment_method' => $method,
            'payment_amount' => $booking['total_price'],
            'payment_status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s'),
        ];

        $payment ? $paymentModel->update($payment['id'], $paymentData) : $paymentModel->insert($paymentData);
        $bookingModel->update($booking['id'], ['booking_status' => 'confirmed', 'payment_status' => 'paid']);

        $ticketModel = new ETicketModel();
        if (! $ticketModel->where('booking_id', $booking['id'])->first()) {
            $ticketCode = 'ET-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
            $ticketModel->insert([
                'booking_id' => $booking['id'],
                'ticket_code' => $ticketCode,
                'qr_code_text' => $ticketCode,
                'ticket_status' => 'active',
                'issued_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return redirect()->to('/payment/success/' . $bookingCode);
    }

    public function success($bookingCode)
    {
        $booking = (new BookingModel())->getDetailByCode($bookingCode);

        return view('payment/success', $this->layoutData([
            'title' => 'Pembayaran Berhasil',
            'booking' => $booking,
        ]));
    }

    public function failed($bookingCode)
    {
        return view('payment/failed', $this->layoutData([
            'title' => 'Pembayaran Gagal',
            'bookingCode' => $bookingCode,
        ]));
    }
}
