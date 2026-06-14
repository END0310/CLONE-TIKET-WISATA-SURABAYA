<?= view('admin/layout/header', ['title' => $title]) ?>
<div class="row g-3">
<?php $cards = [['Total Destinasi',$totalDestinations,'primary'],['Total Booking',$totalBookings,'info'],['Booking Paid',$totalPaid,'success'],['Booking Unpaid',$totalUnpaid,'warning'],['E-Ticket Active',$totalActiveTickets,'success'],['Tiket Used',$totalUsedTickets,'secondary'],['Pesan Kontak',$totalMessages,'danger']]; ?>
<?php foreach ($cards as $card): ?><div class="col-md-4 col-xl-3"><div class="card admin-card"><div class="card-body"><div class="text-muted small"><?= esc($card[0]) ?></div><div class="display-6 fw-bold text-<?= esc($card[2]) ?>"><?= esc($card[1]) ?></div></div></div></div><?php endforeach; ?>
</div>
<?= view('admin/layout/footer') ?>
