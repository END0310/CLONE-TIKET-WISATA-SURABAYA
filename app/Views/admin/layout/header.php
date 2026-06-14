<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>body{background:#f5f7fb}.admin-sidebar{min-height:100vh;background:#10213f}.admin-sidebar a{color:#dbeafe;text-decoration:none;display:block;padding:11px 16px;border-radius:12px}.admin-sidebar a:hover,.admin-sidebar a.active{background:#0d6efd;color:#fff}.admin-card{border:0;border-radius:18px;box-shadow:0 8px 24px rgba(0,0,0,.06)}</style>
</head>
<body>
<div class="container-fluid"><div class="row">
<?= view('admin/layout/sidebar') ?>
<main class="col-md-9 col-lg-10 p-4"><div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="h3 fw-bold mb-0"><?= esc($title ?? 'Admin') ?></h1><div class="text-muted small">Tiket Wisata Surabaya</div></div><a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger rounded-pill">Logout</a></div>
