<?= view('admin/layout/header', ['title' => $title]) ?>
<div class="card admin-card"><div class="card-body">
    <?php if ($validation): ?><div class="alert alert-danger"><?= $validation->listErrors() ?></div><?php endif; ?>
    <form action="<?= base_url('/admin/destinations/store') ?>" method="post" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-lg-4">
                <label class="form-label fw-semibold">Preview Gambar</label>
                <img id="imagePreview" src="https://placehold.co/900x600?text=Destinasi+Wisata" alt="Preview" class="img-fluid rounded-4 border mb-3" style="width:100%;height:240px;object-fit:cover">
                <label class="form-label">Upload Gambar</label>
                <input type="file" name="image_file" id="imageFile" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                <div class="form-text">Format JPG, PNG, WEBP. Maksimal 2 MB.</div>
            </div>
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-md-8"><label class="form-label">Nama Wisata</label><input type="text" name="name" class="form-control" value="<?= old('name') ?>" required></div>
                    <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select" required><?php foreach (['Buka','Tutup hari ini','Ditutup sementara'] as $status): ?><option value="<?= esc($status) ?>" <?= old('status', 'Buka') === $status ? 'selected' : '' ?>><?= esc($status) ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-6"><label class="form-label">Kategori</label><select name="category_id" class="form-select" required><option value="">Pilih kategori</option><?php foreach ($categories as $category): ?><option value="<?= esc($category['id']) ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></div>
                    <div class="col-md-6"><label class="form-label">URL Gambar</label><input type="text" name="image_url" id="imageUrl" class="form-control" value="<?= old('image_url') ?>" placeholder="Opsional jika upload file"></div>
                    <div class="col-12"><label class="form-label">Lokasi</label><textarea name="location" class="form-control" rows="2" placeholder="Contoh: Jl. Tunjungan, Surabaya"><?= old('location') ?></textarea></div>
                    <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="description" class="form-control" rows="5" required><?= old('description') ?></textarea></div>
                    <div class="col-md-6"><label class="form-label">Nama Tiket Awal</label><input type="text" name="ticket_name" class="form-control" value="<?= old('ticket_name', 'Tiket Reguler') ?>" required></div>
                    <div class="col-md-6"><label class="form-label">Harga Tiket Awal</label><input type="number" name="ticket_price" min="0" step="100" class="form-control" value="<?= old('ticket_price', 0) ?>" required></div>
                    <div class="col-12"><label class="form-label">Deskripsi Tiket</label><input type="text" name="ticket_description" class="form-control" value="<?= old('ticket_description', 'Tiket masuk destinasi wisata.') ?>"></div>
                    <div class="col-12"><div class="form-check"><input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured" <?= old('is_featured', 1) ? 'checked' : '' ?>><label class="form-check-label" for="isFeatured">Tampilkan sebagai destinasi unggulan</label></div></div>
                </div>
                <div class="mt-4"><button class="btn btn-primary rounded-pill px-4">Simpan Wisata</button><a href="<?= base_url('/admin/destinations') ?>" class="btn btn-outline-secondary rounded-pill px-4">Batal</a></div>
            </div>
        </div>
    </form>
</div></div>
<script>
document.getElementById('imageFile').addEventListener('change', function(){const file=this.files[0];if(file){document.getElementById('imagePreview').src=URL.createObjectURL(file);}});
document.getElementById('imageUrl').addEventListener('input', function(){if(this.value){document.getElementById('imagePreview').src=this.value;}});
</script>
<?= view('admin/layout/footer') ?>
