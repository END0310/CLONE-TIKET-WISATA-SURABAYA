<?= view('layout/header', ['title' => $title, 'profile' => $profile, 'menus' => $menus]) ?>
<section class="page-header"><div class="container"><h1 class="fw-bold display-5 mb-3"><?= esc($destination['name']) ?></h1><p class="lead mb-0"><?= esc($destination['category_name']) ?> - <?= esc($destination['status']) ?></p></div></section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <img src="<?= esc($destination['image_url']) ?>" class="detail-image mb-4" alt="<?= esc($destination['name']) ?>">
                <div class="content-card mb-4"><h3 class="fw-bold mb-3">Deskripsi</h3><p class="text-muted mb-0"><?= esc($destination['description']) ?></p></div>
                <div class="content-card mb-4"><h3 class="fw-bold mb-3">Lokasi</h3><?php $mapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($destination['location'] ?? $destination['name']); ?><p class="mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i><?= esc($destination['location']) ?></p><a href="<?= esc($mapsUrl) ?>" target="_blank" rel="noopener" class="btn btn-outline-primary rounded-pill px-4"><i class="bi bi-map me-2"></i>Buka di Maps</a></div>
                <div class="content-card"><h3 class="fw-bold mb-3">Syarat dan Ketentuan</h3><?php if (!empty($terms)): ?><ol class="mb-0"><?php foreach ($terms as $term): ?><li class="mb-2"><?= esc($term['content']) ?></li><?php endforeach; ?></ol><?php else: ?><p class="text-muted mb-0">Belum ada syarat dan ketentuan.</p><?php endif; ?></div>
            </div>
            <div class="col-lg-4">
                <div class="content-card mb-4"><h4 class="fw-bold mb-3">Informasi Destinasi</h4><div class="mb-3"><div class="small text-muted">Kategori</div><div class="fw-semibold"><?= esc($destination['category_name']) ?></div></div><div class="mb-3"><div class="small text-muted">Status</div><div class="fw-semibold"><?= esc($destination['status']) ?></div></div><a class="btn btn-primary rounded-pill w-100 py-2" href="<?= base_url('/booking/create/' . $destination['id']) ?>">Beli Tiket</a><div class="alert alert-info small mt-3 mb-0">Pemesanan tiket prototype tanpa payment gateway asli.</div></div>
                <div class="content-card mb-4"><h4 class="fw-bold mb-3">Jadwal Kunjungan</h4><?php if (!empty($schedules)): ?><div class="table-responsive"><table class="table table-sm align-middle"><thead><tr><th>Hari</th><th>Jam</th></tr></thead><tbody><?php foreach ($schedules as $schedule): ?><tr><td><?= esc($schedule['day_name']) ?></td><td><?php if ($schedule['is_closed']): ?><span class="badge bg-danger">Tutup</span><?php else: ?><?= esc(substr($schedule['open_time'],0,5)) ?> - <?= esc(substr($schedule['close_time'],0,5)) ?><?php endif; ?></td></tr><?php endforeach; ?></tbody></table></div><?php else: ?><p class="text-muted mb-0">Jadwal belum tersedia.</p><?php endif; ?></div>
                <div class="content-card"><h4 class="fw-bold mb-3">Jenis Tiket</h4><?php if (!empty($ticketTypes)): ?><?php foreach ($ticketTypes as $ticket): ?><?php $price=(float)$ticket['price'];$priceText=$price>0?'Rp '.number_format($price,0,',','.'):'Gratis'; ?><div class="border rounded-4 p-3 mb-3"><div class="fw-bold"><?= esc($ticket['name']) ?></div><div class="text-muted small mb-2"><?= esc($ticket['description']) ?></div><div class="price-text"><?= esc($priceText) ?></div></div><?php endforeach; ?><?php else: ?><p class="text-muted mb-0">Jenis tiket belum tersedia.</p><?php endif; ?></div>
            </div>
        </div>
    </div>
</section>
<?= view('layout/footer', ['profile' => $profile, 'footerLinks' => $footerLinks, 'socialMedia' => $socialMedia, 'contactInfos' => $contactInfos]) ?>
