<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DestinationCategoryModel;
use App\Models\TicketTypeModel;
use App\Models\TourismDestinationModel;

class DestinationAdmin extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/destinations/index', [
            'title' => 'Data Destinasi',
            'destinations' => (new TourismDestinationModel())->getDestinationsWithCategoryAndPrice(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/destinations/create', [
            'title' => 'Tambah Destinasi',
            'categories' => (new DestinationCategoryModel())->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
            'validation' => session('validation'),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'category_id' => 'required|is_natural_no_zero',
            'name' => 'required|min_length[3]',
            'description' => 'required',
            'location' => 'permit_empty',
            'status' => 'required',
            'ticket_name' => 'required',
            'ticket_price' => 'required|decimal',
            'image_url' => 'permit_empty',
            'image_file' => 'permit_empty|is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[image_file,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $destinationModel = new TourismDestinationModel();
        $ticketModel = new TicketTypeModel();
        $imageUrl = $this->resolveImageUrl();
        $name = trim((string) $this->request->getPost('name'));

        if ($imageUrl === '') {
            $imageUrl = 'https://placehold.co/900x600?text=' . rawurlencode($name);
        }

        $destinationId = $destinationModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name' => $name,
            'slug' => $this->uniqueSlug($name),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'image_url' => $imageUrl,
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        $ticketModel->insert([
            'destination_id' => $destinationId,
            'name' => $this->request->getPost('ticket_name'),
            'description' => $this->request->getPost('ticket_description') ?: 'Tiket masuk destinasi wisata.',
            'price' => (float) $this->request->getPost('ticket_price'),
            'is_active' => 1,
        ]);

        return redirect()->to('/admin/destinations')->with('success', 'Destinasi baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $destinationModel = new TourismDestinationModel();
        $destination = $destinationModel->find($id);

        if (! $destination) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Destinasi tidak ditemukan');
        }

        return view('admin/destinations/edit', [
            'title' => 'Edit Destinasi',
            'destination' => $destination,
            'categories' => (new DestinationCategoryModel())->where('is_active', 1)->orderBy('name', 'ASC')->findAll(),
            'validation' => session('validation'),
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $destinationModel = new TourismDestinationModel();
        $destination = $destinationModel->find($id);

        if (! $destination) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Destinasi tidak ditemukan');
        }

        $rules = [
            'category_id' => 'required|is_natural_no_zero',
            'name' => 'required|min_length[3]',
            'description' => 'required',
            'location' => 'permit_empty',
            'status' => 'required',
            'image_url' => 'permit_empty',
            'image_file' => 'permit_empty|is_image[image_file]|mime_in[image_file,image/jpg,image/jpeg,image/png,image/webp]|max_size[image_file,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $imageUrl = $this->resolveImageUrl();

        $destinationModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'location' => $this->request->getPost('location'),
            'image_url' => $imageUrl !== '' ? $imageUrl : $destination['image_url'],
            'status' => $this->request->getPost('status'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        return redirect()->to('/admin/destinations')->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $destinationModel = new TourismDestinationModel();
        $destination = $destinationModel->find($id);

        if (! $destination) {
            return redirect()->to('/admin/destinations')->with('error', 'Destinasi tidak ditemukan.');
        }

        try {
            $destinationModel->delete($id);
        } catch (\Throwable $e) {
            return redirect()->to('/admin/destinations')->with('error', 'Destinasi tidak bisa dihapus karena sudah memiliki data booking/tiket terkait.');
        }

        return redirect()->to('/admin/destinations')->with('success', 'Destinasi berhasil dihapus.');
    }

    private function resolveImageUrl(): string
    {
        $imageUrl = trim((string) $this->request->getPost('image_url'));
        $imageFile = $this->request->getFile('image_file');

        if ($imageFile && $imageFile->isValid() && ! $imageFile->hasMoved()) {
            $uploadPath = ROOTPATH . 'public/uploads/destinations';

            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $imageFile->getRandomName();
            $imageFile->move($uploadPath, $newName);
            return '/uploads/destinations/' . $newName;
        }

        return $imageUrl;
    }

    private function uniqueSlug(string $name): string
    {
        $base = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-')) ?: 'destinasi';
        $slug = $base;
        $index = 2;
        $model = new TourismDestinationModel();

        while ($model->where('slug', $slug)->first()) {
            $slug = $base . '-' . $index;
            $index++;
        }

        return $slug;
    }
}
