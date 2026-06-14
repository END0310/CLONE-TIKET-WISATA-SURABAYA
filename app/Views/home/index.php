<?= view('layout/header', ['title' => $title, 'profile' => $profile, 'menus' => $menus]) ?>
<?php $heroImage = $profile['hero_image'] ?? 'https://placehold.co/1600x900?text=Wisata+Surabaya'; ?>
<section class="hero-section" style="background-image:url('<?= esc($heroImage) ?>');">
    <div class="container hero-content">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <h1 class="display-3 fw-bold mb-4">Budaya Baru Berwisata<br>Di Kota Surabaya</h1>
                <p class="lead mb-4">Dinas Kebudayaan, Kepemudaan dan Olahraga serta Pariwisata<br>Pemerintah Kota Surabaya</p>
                <a href="<?= base_url('/destinations') ?>" class="btn btn-light btn-lg rounded-pill px-4">Jelajahi Wisata</a>
            </div>
            <div class="col-lg-5">
                <div class="planning-card">
                    <h3 class="fw-bold mb-4 text-primary">Rencanakan Harimu!</h3>
                    <form onsubmit="event.preventDefault();redirectToDestination();">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Destinasi Wisata</label>
                            <select class="form-select" id="destinationSelect" required>
                                <option value="">Pilih salah satu</option>
                                <?php foreach ($destinations as $destination): ?>
                                    <option value="<?= esc($destination['id']) ?>"><?= esc($destination['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Hari Kunjungan</label>
                            <select class="form-select" id="daySelect"><option value="">Pilih hari kunjungan</option><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Jam Kunjungan</label>
                            <select class="form-select" id="timeSelect"><option value="">Pilih jam kunjungan</option><option>08:00 - 10:00</option><option>10:00 - 12:00</option><option>13:00 - 15:00</option><option>15:00 - 16:00</option></select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Pesan Tiket</button>
                        <div class="small text-muted mt-3 text-center">Tahap pertama: tombol diarahkan ke detail destinasi.</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7"><div class="info-box h-100"><h4 class="fw-bold mb-3"><i class="bi bi-info-circle-fill text-primary me-2"></i>Info</h4><ul class="mb-0"><li class="mb-2">Wisata Perahu Kalimas tidak melayani tiket on the spot.</li><li class="mb-2">Tiket yang sudah dibayar tidak dapat dikembalikan.</li><li class="mb-2">Tiket tidak dapat discan jika pengunjung terlambat check-in.</li><li class="mb-2">Pastikan pengunjung membaca ketentuan sebelum memesan tiket.</li></ul></div></div>
            <div class="col-lg-5"><div class="info-box h-100"><h4 class="fw-bold mb-3"><i class="bi bi-megaphone-fill text-primary me-2"></i>Akses Informasi</h4><p class="text-muted">Informasi terkait aplikasi Tiket Wisata Surabaya dapat dilihat pada laman instagram berikut.</p><?php foreach ($socialMedia as $social): ?><a href="<?= esc($social['url']) ?>" target="_blank" class="btn btn-outline-primary rounded-pill me-2 mb-2"><i class="<?= esc($social['icon'] ?? 'bi bi-link') ?> me-1"></i><?= esc($social['username']) ?></a><?php endforeach; ?></div></div>
        </div>
    </div>
</section>
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4"><div><h2 class="section-title mb-1">Jelajahi Wisata Surabaya</h2><p class="text-muted mb-0">Pilih destinasi wisata dan lihat informasi kunjungan.</p></div><a href="<?= base_url('/destinations') ?>" class="btn btn-primary rounded-pill px-4">Lihat Semua</a></div>
        <div class="row g-4">
            <?php foreach ($featuredDestinations as $destination): ?>
                <?php $status=$destination['status'];$badgeClass='bg-success';if($status==='Tutup'){$badgeClass='bg-danger';}elseif($status==='Tutup hari ini'){$badgeClass='bg-warning text-dark';}$startPrice=(float)($destination['start_price']??0);$priceText=$startPrice>0?'Rp '.number_format($startPrice,0,',','.'):'Gratis'; ?>
                <div class="col-md-6 col-lg-3"><div class="card destination-card"><img src="<?= esc($destination['image_url']) ?>" class="card-img-top" alt="<?= esc($destination['name']) ?>"><div class="card-body"><span class="badge <?= $badgeClass ?> badge-status mb-3"><?= esc($status) ?></span><h5 class="fw-bold"><?= esc($destination['name']) ?></h5><p class="mb-3 price-text"><?= esc($priceText) ?></p><a href="<?= base_url('/destinations/detail/'.$destination['id']) ?>" class="btn btn-outline-primary rounded-pill w-100">Detail</a></div></div></div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<div class="modal fade" id="announcementModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content border-0 rounded-4"><div class="modal-header border-0"><h4 class="modal-title fw-bold text-primary">PENGUMUMAN</h4><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Gunakan metode pembayaran QRIS untuk menikmati kemudahan pembayaran tiket wisata. Pastikan data pemesanan sudah benar sebelum melakukan pembayaran.</p><div class="alert alert-warning mb-0">Prototype tahap pertama belum menjalankan fitur pembayaran.</div></div><div class="modal-footer border-0"><button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">Saya mengerti!</button></div></div></div></div>
<script>
function redirectToDestination(){const destinationId=document.getElementById('destinationSelect').value;if(!destinationId){alert('Silakan pilih destinasi terlebih dahulu.');return;}window.location.href='<?= base_url('/destinations/detail') ?>/'+destinationId;}
document.addEventListener('DOMContentLoaded',function(){const modal=new bootstrap.Modal(document.getElementById('announcementModal'));modal.show();});
</script>
<?= view('layout/footer', ['profile' => $profile, 'footerLinks' => $footerLinks, 'socialMedia' => $socialMedia, 'contactInfos' => $contactInfos]) ?>
