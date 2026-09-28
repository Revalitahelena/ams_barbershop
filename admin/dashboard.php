<?php
require_once __DIR__.'/../includes/auth.php';
$pageTitle='Dashboard';$activeMenu='dashboard';
$totalBooking=(int)$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pending=(int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status='pending'")->fetchColumn();
$totalBarber=(int)$pdo->query("SELECT COUNT(*) FROM barbers")->fetchColumn();
require __DIR__.'/includes/layout_top.php';
?>
<div class="panel"><h2>Selamat datang di Admin AMS Barbershop</h2><p>Kelola booking, layanan, dan barber dari halaman ini.</p></div>
<div class="form-grid">
<div class="panel"><h3>Total Booking</h3><strong><?=$totalBooking?></strong></div>
<div class="panel"><h3>Booking Pending</h3><strong><?=$pending?></strong></div>
<div class="panel"><h3>Total Barber</h3><strong><?=$totalBarber?></strong></div>
</div>
<?php require __DIR__.'/includes/layout_bottom.php'; ?>
