<?= view('layout/header', ['title' => $title, 'profile' => $profile, 'menus' => $menus]) ?>
<section class="page-header"><div class="container"><h1 class="fw-bold">Booking Tiket</h1><p class="lead mb-0"><?= esc($destination['name']) ?></p></div></section>
<section class="py-5"><div class="container"><div class="row g-4">
    <div class="col-lg-4"><div class="content-card"><img src="<?= esc($destination['image_url']) ?>" class="img-fluid rounded-4 mb-3" alt=""><h4 class="fw-bold"><?= esc($destination['name']) ?></h4><?php $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($destination['location'] ?? $destination['name']); ?><p class="text-muted mb-2"><?= esc($destination['location']) ?></p><a href="<?= esc($mapsUrl) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi bi-map me-1"></i>Buka Maps</a></div></div>
    <div class="col-lg-8"><div class="content-card">
        <?php if (session('error')): ?><div class="alert alert-danger"><?= esc(session('error')) ?></div><?php endif; ?>
        <form action="<?= base_url('/booking/store') ?>" method="post">
            <input type="hidden" name="destination_id" value="<?= esc($destination['id']) ?>">
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Jenis Tiket</label><select class="form-select" name="ticket_type_id" id="ticketType" required><option value="">Pilih tiket</option><?php foreach ($ticketTypes as $ticket): ?><option value="<?= esc($ticket['id']) ?>" data-price="<?= esc($ticket['price']) ?>" <?= old('ticket_type_id') == $ticket['id'] ? 'selected' : '' ?>><?= esc($ticket['name']) ?> - Rp <?= number_format((float) $ticket['price'], 0, ',', '.') ?></option><?php endforeach; ?></select></div>
                <div class="col-md-3"><label class="form-label">Tanggal</label><input type="date" name="visit_date" class="form-control" value="<?= old('visit_date', date('Y-m-d')) ?>" required></div>
                <div class="col-md-3"><label class="form-label">Jam</label><input type="time" name="visit_time" class="form-control" value="<?= old('visit_time', '09:00') ?>" required></div>
                <div class="col-md-6"><label class="form-label">Nama Pengunjung</label><input type="text" name="visitor_name" class="form-control" value="<?= old('visitor_name') ?>" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="visitor_email" class="form-control" value="<?= old('visitor_email') ?>" required></div>
                <div class="col-md-6"><label class="form-label">No HP</label><input type="text" name="visitor_phone" class="form-control" value="<?= old('visitor_phone') ?>" required></div>
                <div class="col-md-6"><label class="form-label">Jumlah Tiket</label><input type="number" name="quantity" id="quantity" min="1" class="form-control" value="<?= old('quantity', 1) ?>" required></div>
                <div class="col-12"><label class="form-label">Catatan</label><textarea name="notes" class="form-control" rows="3"><?= old('notes') ?></textarea></div>
            </div>
            <div class="alert alert-primary d-flex justify-content-between align-items-center mt-4"><span>Total Harga</span><strong id="totalPrice">Rp 0</strong></div>
            <button class="btn btn-primary rounded-pill px-4">Buat Booking</button>
        </form>
    </div></div>
</div></div></section>
<script>
function rupiah(value){return 'Rp '+Number(value||0).toLocaleString('id-ID');}
function updateTotal(){const selected=document.querySelector('#ticketType option:checked');const price=selected?Number(selected.dataset.price||0):0;const qty=Number(document.getElementById('quantity').value||1);document.getElementById('totalPrice').textContent=rupiah(price*qty);}document.getElementById('ticketType').addEventListener('change',updateTotal);document.getElementById('quantity').addEventListener('input',updateTotal);updateTotal();
</script>
<?= view('layout/footer', ['profile' => $profile, 'footerLinks' => $footerLinks, 'socialMedia' => $socialMedia, 'contactInfos' => $contactInfos]) ?>
