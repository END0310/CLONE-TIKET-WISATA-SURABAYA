<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;

class Contact extends BaseController
{
    public function index()
    {
        return view('pages/contact', $this->layoutData([
            'title' => 'Kontak Kami',
            'validation' => session('validation'),
        ]));
    }

    public function send()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'subject' => 'required',
            'message' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        (new ContactMessageModel())->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
            'status' => 'new',
        ]);

        return redirect()->to('/contact')->with('success', 'Pesan berhasil dikirim.');
    }
}
