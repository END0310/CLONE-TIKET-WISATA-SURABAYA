<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-primary-subtle">
<div class="container py-5">
    <div class="card border-0 shadow mx-auto" style="max-width:460px">
        <div class="card-body p-4">
            <a href="<?= base_url('/') ?>" class="text-decoration-none small"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            <h3 class="fw-bold text-primary mt-3 mb-2">Login Tiket Wisata</h3>
            <p class="text-muted">Gunakan halaman ini untuk login pengguna maupun admin.</p>
            <?php if (session('error')): ?><div class="alert alert-danger"><?= esc(session('error')) ?></div><?php endif; ?>
            <a href="<?= base_url('/login/google') ?>" class="btn btn-light border w-100 rounded-pill mb-3">
                <i class="bi bi-google text-danger me-2"></i>Login Pengguna dengan Google
            </a>
            <div class="d-flex align-items-center gap-3 mb-3"><hr class="flex-grow-1"><span class="small text-muted">atau</span><hr class="flex-grow-1"></div>
            <form action="<?= base_url('/login/process') ?>" method="post">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control mb-3" value="<?= old('email') ?>" required>
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control mb-4" required>
                <button class="btn btn-primary w-100 rounded-pill">Login</button>
            </form>
            <div class="bg-light rounded-4 p-3 mt-4 small">
                <div class="fw-bold mb-2">Akun Demo</div>
                <div>Admin: <code>admin@tiketwisata.test</code> / <code>password</code></div>
                <div>Pengguna: <code>user@tiketwisata.test</code> / <code>password</code></div>
                <div class="mt-2 text-muted">Google Login butuh konfigurasi OAuth di file <code>.env</code>.</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
