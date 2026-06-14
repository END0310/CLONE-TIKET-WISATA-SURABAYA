<footer class="footer mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h5 class="fw-bold mb-3">Tentang Kami</h5>
                <p class="mb-3"><?= esc($profile['description'] ?? 'Aplikasi Tiket Wisata Surabaya hadir sebagai solusi informasi wisata Kota Surabaya.') ?></p>
                <?php if (!empty($contactInfos)): ?>
                    <ul class="list-unstyled small">
                        <?php foreach ($contactInfos as $contact): ?>
                            <li class="mb-2"><i class="bi bi-dot"></i><strong><?= esc($contact['label']) ?>:</strong> <?= esc($contact['value']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-lg-3">
                <h5 class="fw-bold mb-3">Lainnya</h5>
                <ul class="list-unstyled">
                    <?php if (!empty($footerLinks)): ?>
                        <?php foreach ($footerLinks as $link): ?>
                            <li class="mb-2"><a href="<?= base_url($link['url']) ?>"><?= esc($link['title']) ?></a></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li><a href="<?= base_url('/') ?>">Home</a></li>
                        <li><a href="<?= base_url('/destinations') ?>">Destinasi</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">Sosial Media</h5>
                <?php if (!empty($socialMedia)): ?>
                    <?php foreach ($socialMedia as $social): ?>
                        <a href="<?= esc($social['url']) ?>" target="_blank" class="d-inline-flex align-items-center me-3 mb-2"><i class="<?= esc($social['icon'] ?? 'bi bi-link') ?> me-2"></i><?= esc($social['username']) ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <hr class="border-light opacity-25 my-4">
        <div class="text-center small">&copy; <?= date('Y') ?> <?= esc($profile['site_name'] ?? 'Tiket Wisata Surabaya') ?>. Prototype lokal.</div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
