<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nama=trim($_POST['nama']??'');
$wa=trim($_POST['whatsapp']??'');
$layanan=trim($_POST['layanan']??'');
$harga=(int)($_POST['harga']??0);
$barber=trim($_POST['barber']??'');
$tanggal=trim($_POST['tanggal']??'');
$jam=trim($_POST['jam']??'');

if ($nama==='' || $wa==='' || $layanan==='' || $tanggal==='' || $jam==='') {
    header('Location: index.php?booking=error#booking');
    exit;
}

$stmt=$pdo->prepare("INSERT INTO bookings (nama, whatsapp, layanan, harga, barber, tanggal, jam, status)
VALUES (?,?,?,?,?,?,?,'pending')");
$stmt->execute([$nama,$wa,$layanan,$harga,$barber,$tanggal,$jam]);

$pesan="Halo AMS Barbershop! Saya ingin reservasi.\n\n"
       ."Nama: {$nama}\nLayanan: {$layanan}\nBarber: {$barber}\n"
       ."Tanggal: {$tanggal}, Jam: {$jam}\n\nTerima kasih!";
header('Location: https://wa.me/'.WA_NUMBER.'?text='.urlencode($pesan));
exit;
