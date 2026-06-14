<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Tiket Wisata Surabaya') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body{font-family:Arial,sans-serif;background:#f7f9fc}.navbar{background:#fff}.navbar-brand{font-weight:800;color:#0d6efd!important}.nav-link{font-weight:600;color:#333!important}.nav-link:hover{color:#0d6efd!important}.hero-section{min-height:650px;background-size:cover;background-position:center;position:relative;color:#fff;display:flex;align-items:center}.hero-section:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,rgba(0,38,89,.84),rgba(0,123,255,.45))}.hero-content{position:relative;z-index:2}.planning-card{background:#fff;border-radius:22px;padding:28px;box-shadow:0 18px 50px rgba(0,0,0,.16);color:#222}.section-title{font-weight:800;color:#1e2b4f}.destination-card{border:0;border-radius:18px;overflow:hidden;box-shadow:0 10px 28px rgba(0,0,0,.08);transition:.25s;height:100%}.destination-card:hover{transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,.12)}.destination-card img{height:210px;object-fit:cover}.badge-status{border-radius:30px;padding:7px 12px;font-size:12px}.price-text{color:#0d6efd;font-weight:800}.info-box,.content-card{background:#fff;border-radius:18px;padding:24px;box-shadow:0 8px 24px rgba(0,0,0,.06)}.footer{background:#10213f;color:#fff;padding:55px 0 25px}.footer a{color:#dbeafe;text-decoration:none}.footer a:hover{color:#fff}.page-header{background:linear-gradient(90deg,#0d6efd,#0dcaf0);color:#fff;padding:90px 0 70px}.detail-image{width:100%;max-height:520px;object-fit:cover;border-radius:22px}.ticket-card{border:2px dashed #0d6efd;border-radius:24px;background:#fff}.qr-box{height:180px;border:3px solid #10213f;border-radius:18px;display:flex;align-items:center;justify-content:center;text-align:center;font-weight:800;background:#f8fbff}.status-badge{border-radius:30px;padding:6px 12px;font-size:12px;text-transform:uppercase}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="bi bi-ticket-perforated-fill me-2"></i><?= esc($profile['site_name'] ?? 'Tiket Wisata Surabaya') ?>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Beranda</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Informasi Tiket</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= base_url('/destinations') ?>">Harga Tiket</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/faq') ?>">Cara Pesan Tiket</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('/faq') ?>">FAQ</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/contact') ?>">Kontak Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tiket Masif</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('/cancellation') ?>">Pembatalan Tiket</a></li>
                <li class="nav-item ms-lg-3"><a class="btn btn-primary rounded-pill px-4" href="<?= base_url('/destinations') ?>">Destinasi</a></li>
                <?php if (session()->get('isLoggedIn')): ?>
                    <?php $dashboardUrl = session()->get('userRole') === 'admin' ? '/admin/dashboard' : '/user/dashboard'; ?>
                    <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary rounded-pill px-4" href="<?= base_url($dashboardUrl) ?>"><?= esc(session()->get('userName')) ?></a></li>
                    <li class="nav-item ms-lg-2"><a class="nav-link" href="<?= base_url('/logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary rounded-pill px-4" href="<?= base_url('/login') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
