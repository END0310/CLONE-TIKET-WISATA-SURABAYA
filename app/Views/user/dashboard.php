<?= view('layout/header', ['title' => $title, 'profile' => $profile, 'menus' => $menus]) ?>
<section class="page-header"><div class="container"><h1 class="fw-bold">Dashboard Pengguna</h1><p class="lead mb-0">Halo, <?= esc(session()->get('userName')) ?></p></div></section>
<section class="py-5"><div class="container">
    <?php if (session('error')): ?><div class="alert alert-warning"><?= esc(session('error')) ?></div><?php endif; ?>
    <div class="content-card mb-4">
        <h4 class="fw-bold mb-2">Akun Saya</h4>
        <p class="mb-1"><strong>Email:</strong> <?= esc(session()->get('userEmail')) ?></p>
        <p class="mb-0"><strong>Role:</strong> <?= esc(session()->get('userRole')) ?></p>
    </div>
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-3"><h4 class="fw-bold mb-0">Riwayat Booking</h4><a href="<?= base_url('/destinations') ?>" class="btn btn-primary rounded-pill">Pesan Tiket</a></div>
        <?php if (empty($bookings)): ?>
            <div class="alert alert-info mb-0">Belum ada booking untuk email akun ini.</div>
        <?php else: ?>
            <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Kode</th><th>Destinasi</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead><tbody><?php foreach ($bookings as $booking): ?><tr><td><?= esc($booking['booking_code']) ?></td><td><?= esc($booking['destination_name']) ?></td><td><?= esc($booking['visit_date']) ?></td><td>Rp <?= number_format((float) $booking['total_price'], 0, ',', '.') ?></td><td><span class="badge bg-primary"><?= esc($booking['booking_status']) ?></span> <span class="badge bg-secondary"><?= esc($booking['payment_status']) ?></span></td><td><a class="btn btn-sm btn-outline-primary rounded-pill" href="<?= base_url('/booking/detail/' . $booking['booking_code']) ?>">Detail</a></td></tr><?php endforeach; ?></tbody></table></div>
        <?php endif; ?>
    </div>
</div></section>
<?= view('layout/footer', ['profile' => $profile, 'footerLinks' => $footerLinks, 'socialMedia' => $socialMedia, 'contactInfos' => $contactInfos]) ?>
