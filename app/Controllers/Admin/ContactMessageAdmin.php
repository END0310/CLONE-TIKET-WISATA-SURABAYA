<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;

class ContactMessageAdmin extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/contact_messages/index', [
            'title' => 'Pesan Kontak',
            'messages' => (new ContactMessageModel())->orderBy('id', 'DESC')->findAll(),
        ]);
    }
}
