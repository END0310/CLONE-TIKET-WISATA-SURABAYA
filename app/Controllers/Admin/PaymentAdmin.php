<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentModel;

class PaymentAdmin extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/payments/index', [
            'title' => 'Data Pembayaran',
            'payments' => (new PaymentModel())->getAdminRows(),
        ]);
    }
}
