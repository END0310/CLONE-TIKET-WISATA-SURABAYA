<?php

namespace App\Controllers;

use App\Models\BookingModel;
use App\Models\TicketTypeModel;
use App\Models\TourismDestinationModel;

class Booking extends BaseController
{
    public function create($destinationId)
    {
        $destinationModel = new TourismDestinationModel();
        $ticketModel = new TicketTypeModel();
        $destination = $destinationModel->find($destinationId);

        if (! $destination) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Destinasi tidak ditemukan');
        }

        return view('booking/create', $this->layoutData([
            'title' => 'Booking Tiket',
            'destination' => $destination,
            'ticketTypes' => $ticketModel->where('destination_id', $destinationId)->where('is_active', 1)->findAll(),
            'validation' => session('validation'),
        ]));
    }

    public function store()
    {
        $rules = [
            'destination_id' => 'required|is_natural_no_zero',
            'ticket_type_id' => 'required|is_natural_no_zero',
            'visitor_name' => 'required|min_length[3]',
            'visitor_email' => 'required|valid_email',
            'visitor_phone' => 'required',
            'visit_date' => 'required|valid_date[Y-m-d]',
            'visit_time' => 'required',
            'quantity' => 'required|integer|greater_than_equal_to[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $ticketModel = new TicketTypeModel();
        $ticket = $ticketModel->find($this->request->getPost('ticket_type_id'));

        if (! $ticket || (int) $ticket['destination_id'] !== (int) $this->request->getPost('destination_id')) {
            return redirect()->back()->withInput()->with('error', 'Jenis tiket tidak valid.');
        }

        $quantity = (int) $this->request->getPost('quantity');
        $price = (float) $ticket['price'];
        $visitDate = $this->request->getPost('visit_date');
        $dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

        $bookingModel = new BookingModel();
        $bookingCode = 'TWS-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));

        $bookingModel->insert([
            'booking_code' => $bookingCode,
            'destination_id' => $this->request->getPost('destination_id'),
            'ticket_type_id' => $ticket['id'],
            'visitor_name' => $this->request->getPost('visitor_name'),
            'visitor_email' => $this->request->getPost('visitor_email'),
            'visitor_phone' => $this->request->getPost('visitor_phone'),
            'visit_date' => $visitDate,
            'visit_day' => $dayNames[(int) date('w', strtotime($visitDate))],
            'visit_time' => $this->request->getPost('visit_time'),
            'quantity' => $quantity,
            'ticket_price' => $price,
            'total_price' => $price * $quantity,
            'booking_status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/booking/detail/' . $bookingCode);
    }

    public function detail($bookingCode)
    {
        $booking = (new BookingModel())->getDetailByCode($bookingCode);

        if (! $booking) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Booking tidak ditemukan');
        }

        return view('booking/detail', $this->layoutData([
            'title' => 'Detail Booking',
            'booking' => $booking,
        ]));
    }
}
