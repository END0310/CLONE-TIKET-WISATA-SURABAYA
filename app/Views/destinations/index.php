<?= view('layout/header', ['title' => $title, 'profile' => $profile, 'menus' => $menus]) ?>
<section class="page-header"><div class="container"><h1 class="fw-bold display-5 mb-3">Daftar Destinasi Wisata</h1><p class="lead mb-0">Temukan berbagai destinasi wisata Kota Surabaya dan lihat detail jadwal serta harga tiket.</p></div></section>
<section class="py-5">
    <div class="container">
        <div class="content-card mb-4">
            <form method="get" action="<?= base_url('/destinations') ?>" class="row g-3 align-items-end">
                <div class="col-md-9"><label class="form-label fw-semibold">Filter Kategori Destinasi</label><select name="category" class="form-select"><option value="">Semua Kategori</option><?php foreach ($categories as $category): ?><option value="<?= esc($category['id']) ?>" <?= $selectedCategory == $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option><?php endforeach; ?></select></div>
                <div class="col-md-3"><button class="btn btn-primary w-100 rounded-pill">Filter</button></div>
            </form>
        </div>
        <div class="row g-4">
            <?php if (!empty($destinations)): ?>
                <?php foreach ($destinations as $destination): ?>
                    <?php $status=$destination['status'];$badgeClass='bg-success';if($status==='Tutup'){$badgeClass='bg-danger';}elseif($status==='Tutup hari ini'){$badgeClass='bg-warning text-dark';}$startPrice=(float)($destination['start_price']??0);$priceText=$startPrice>0?'Rp '.number_format($startPrice,0,',','.'):'Gratis'; ?>
                    <div class="col-md-6 col-lg-4"><div class="card destination-card"><img src="<?= esc($destination['image_url']) ?>" class="card-img-top" alt="<?= esc($destination['name']) ?>"><div class="card-body"><div class="d-flex justify-content-between align-items-center mb-3"><span class="badge <?= $badgeClass ?> badge-status"><?= esc($status) ?></span><small class="text-muted"><?= esc($destination['category_name']) ?></small></div><h5 class="fw-bold"><?= esc($destination['name']) ?></h5><p class="text-muted small"><?= esc(substr($destination['description'],0,120)) ?>...</p><p class="price-text mb-3">Mulai dari <?= esc($priceText) ?></p><a href="<?= base_url('/destinations/detail/'.$destination['id']) ?>" class="btn btn-outline-primary rounded-pill w-100">Detail</a></div></div></div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12"><div class="alert alert-info">Belum ada destinasi pada kategori ini.</div></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?= view('layout/footer', ['profile' => $profile, 'footerLinks' => $footerLinks, 'socialMedia' => $socialMedia, 'contactInfos' => $contactInfos]) ?>
